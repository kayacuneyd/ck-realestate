<?php

namespace App\Modules\OpenImmo\Services;

use App\Modules\Property\Models\PropertyModel;
use App\Modules\Property\Entities\Property;

/**
 * PropertyMapper Service
 * 
 * Maps OpenImmo parsed data to Property entity format
 * and handles database synchronization.
 */
class PropertyMapper
{
    protected PropertyModel $propertyModel;
    protected array $stats = [
        'inserted' => 0,
        'updated' => 0,
        'deleted' => 0,
        'skipped' => 0,
        'errors' => [],
    ];

    public function __construct()
    {
        $this->propertyModel = new PropertyModel();
    }

    /**
     * Map OpenImmo property data to database format.
     */
    public function mapToDatabase(array $openImmoData, string $providerId): array
    {
        $data = [
            'external_id' => $openImmoData['external_id'],
            'provider_id' => $providerId,
            'title' => $openImmoData['title'] ?? 'Untitled Property',
            'description' => $openImmoData['description'] ?? '',
            'marketing_type' => $openImmoData['marketing_type'],
            'property_type' => $openImmoData['property_type'],

            // Price - use sale price or rent
            'price' => $openImmoData['price'] ?: $openImmoData['cold_rent'],
            'cold_rent' => $openImmoData['cold_rent'],
            'warm_rent' => $openImmoData['warm_rent'],
            'additional_costs' => $openImmoData['additional_costs'],
            'heating_costs' => $openImmoData['heating_costs'],
            'deposit' => $openImmoData['deposit'],
            'commission' => $openImmoData['commission'],

            // Areas
            'area_sqm' => $openImmoData['living_area'] ?: $openImmoData['usable_area'],
            'living_area' => $openImmoData['living_area'],
            'usable_area' => $openImmoData['usable_area'],
            'plot_area' => $openImmoData['plot_area'],

            // Rooms
            'rooms' => $openImmoData['rooms'],
            'bedrooms' => $openImmoData['bedrooms'] ?: (int) floor($openImmoData['rooms'] ?? 0),
            'bathrooms' => $openImmoData['bathrooms'],

            // Location
            'address' => $openImmoData['address'],
            'city' => $openImmoData['city'],
            'zip_code' => $openImmoData['zip_code'],
            'latitude' => $openImmoData['latitude'],
            'longitude' => $openImmoData['longitude'],

            // Building info
            'floor' => $openImmoData['floor'],
            'total_floors' => $openImmoData['total_floors'],
            'construction_year' => $openImmoData['construction_year'],
            'heating_type' => $openImmoData['heating_type'],

            // Energy
            'energy_certificate_type' => $openImmoData['energy_certificate_type'],
            'energy_value' => $openImmoData['energy_value'],
            'energy_class' => $openImmoData['energy_class'],

            // Availability
            'available_from' => $openImmoData['available_from'],

            // Type mapping
            'type' => $this->mapMarketingType($openImmoData['marketing_type']),
            'status' => 'available',

            // Sync tracking
            'last_sync_at' => date('Y-m-d H:i:s'),
        ];

        // Clean up null/empty values
        foreach ($data as $key => $value) {
            if ($value === null || $value === '' || $value === 0.0 || $value === 0) {
                if (!in_array($key, ['external_id', 'provider_id', 'title', 'status', 'type', 'last_sync_at'])) {
                    $data[$key] = null;
                }
            }
        }

        return $data;
    }

    /**
     * Map OpenImmo marketing type to internal type.
     */
    protected function mapMarketingType(?string $marketingType): string
    {
        return match ($marketingType) {
            'KAUF' => 'sale',
            'MIETE', 'MIETE_PACHT' => 'rent',
            default => 'sale',
        };
    }

    /**
     * Sync a property to database (insert or update).
     */
    public function sync(array $openImmoData, string $providerId): bool
    {
        $action = $openImmoData['action'] ?? 'INSERT';
        $externalId = $openImmoData['external_id'];

        if (!$externalId) {
            $this->stats['errors'][] = "Property missing external_id, skipped";
            $this->stats['skipped']++;
            return false;
        }

        // Handle DELETE action
        if ($action === 'DELETE') {
            return $this->deleteProperty($externalId, $providerId);
        }

        // Find existing property
        $existing = $this->findByExternalId($externalId, $providerId);
        $dbData = $this->mapToDatabase($openImmoData, $providerId);

        try {
            if ($existing) {
                // Update existing
                $dbData['slug'] = $existing->slug; // Keep existing slug
                $this->propertyModel->skipValidation(true)->update($existing->id, $dbData);
                $this->stats['updated']++;
            } else {
                // Insert new
                $dbData['slug'] = $this->propertyModel->generateUniqueSlug($dbData['title']);
                $this->propertyModel->skipValidation(true)->insert($dbData);
                $this->stats['inserted']++;
            }
            return true;
        } catch (\Exception $e) {
            $this->stats['errors'][] = "Error syncing {$externalId}: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Find property by external ID and provider.
     */
    public function findByExternalId(string $externalId, string $providerId): ?Property
    {
        return $this->propertyModel
            ->where('external_id', $externalId)
            ->where('provider_id', $providerId)
            ->first();
    }

    /**
     * Delete/deactivate a property.
     */
    protected function deleteProperty(string $externalId, string $providerId): bool
    {
        $existing = $this->findByExternalId($externalId, $providerId);

        if ($existing) {
            // Soft delete by setting status to 'sold'
            $this->propertyModel->update($existing->id, ['status' => 'sold']);
            $this->stats['deleted']++;
            return true;
        }

        return false;
    }

    /**
     * For VOLL (full) transfers, mark properties not in XML as sold.
     */
    public function markMissingAsSold(array $processedExternalIds, string $providerId): int
    {
        $allProperties = $this->propertyModel
            ->where('provider_id', $providerId)
            ->where('status', 'available')
            ->whereNotIn('external_id', $processedExternalIds)
            ->findAll();

        $count = 0;
        foreach ($allProperties as $property) {
            $this->propertyModel->update($property->id, ['status' => 'sold']);
            $count++;
        }

        $this->stats['deleted'] += $count;
        return $count;
    }

    /**
     * Update property images.
     */
    public function updateImages(string $externalId, string $providerId, ?string $mainImage, array $images): void
    {
        $property = $this->findByExternalId($externalId, $providerId);

        if (!$property) {
            return;
        }

        $updateData = [];

        if ($mainImage) {
            $updateData['main_image_url'] = $mainImage;
        }

        if (!empty($images)) {
            $updateData['images'] = json_encode($images);
        }

        if (!empty($updateData)) {
            $this->propertyModel->update($property->id, $updateData);
        }
    }

    /**
     * Get sync statistics.
     */
    public function getStats(): array
    {
        return $this->stats;
    }

    /**
     * Reset statistics.
     */
    public function resetStats(): void
    {
        $this->stats = [
            'inserted' => 0,
            'updated' => 0,
            'deleted' => 0,
            'skipped' => 0,
            'errors' => [],
        ];
    }
}
