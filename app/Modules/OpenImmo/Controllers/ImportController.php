<?php

namespace App\Modules\OpenImmo\Controllers;

use App\Controllers\BaseController;
use App\Modules\OpenImmo\Services\ZipHandler;
use App\Modules\OpenImmo\Services\OpenImmoParser;
use App\Modules\OpenImmo\Services\PropertyMapper;
use App\Modules\OpenImmo\Services\MediaProcessor;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * OpenImmo Import Controller
 * 
 * Handles automated import of OpenImmo XML data from ZIP files.
 * Designed to be called by CRON job.
 */
class ImportController extends BaseController
{
    protected ZipHandler $zipHandler;
    protected OpenImmoParser $parser;
    protected PropertyMapper $mapper;
    protected MediaProcessor $mediaProcessor;
    protected array $logs = [];

    public function __construct()
    {
        $this->zipHandler = new ZipHandler();
        $this->parser = new OpenImmoParser();
        $this->mapper = new PropertyMapper();
        $this->mediaProcessor = new MediaProcessor();
    }

    /**
     * Process pending OpenImmo ZIP files.
     * 
     * This endpoint is designed to be called by CRON job every 15 minutes.
     */
    public function process(): ResponseInterface
    {
        $startTime = microtime(true);
        $this->log("OpenImmo import started");

        // Get pending ZIP files
        $zipFiles = $this->zipHandler->getPendingFiles();

        if (empty($zipFiles)) {
            $this->log("No pending files to process");
            return $this->response->setJSON([
                'status' => 'ok',
                'message' => 'No pending files',
                'logs' => $this->logs,
            ]);
        }

        $this->log("Found " . count($zipFiles) . " file(s) to process");

        $totalStats = [
            'inserted' => 0,
            'updated' => 0,
            'deleted' => 0,
            'skipped' => 0,
            'errors' => [],
        ];

        foreach ($zipFiles as $zipFile) {
            $this->log("Processing: " . basename($zipFile));
            $result = $this->processZipFile($zipFile);

            // Aggregate stats
            if ($result) {
                $stats = $this->mapper->getStats();
                $totalStats['inserted'] += $stats['inserted'];
                $totalStats['updated'] += $stats['updated'];
                $totalStats['deleted'] += $stats['deleted'];
                $totalStats['skipped'] += $stats['skipped'];
                $totalStats['errors'] = array_merge($totalStats['errors'], $stats['errors']);
            }
        }

        $duration = round(microtime(true) - $startTime, 2);
        $this->log("Import completed in {$duration}s");

        // Save import log to database/file
        $this->saveImportLog($totalStats, $duration);

        return $this->response->setJSON([
            'status' => 'ok',
            'duration' => $duration,
            'stats' => $totalStats,
            'logs' => $this->logs,
        ]);
    }

    /**
     * Process a single ZIP file.
     */
    protected function processZipFile(string $zipPath): bool
    {
        // Extract ZIP
        $extractDir = $this->zipHandler->extract($zipPath);

        if (!$extractDir) {
            $this->log("Failed to extract: " . implode(', ', $this->zipHandler->getErrors()));
            return false;
        }

        // Find XML file
        $xmlFile = $this->zipHandler->findXmlFile($extractDir);

        if (!$xmlFile) {
            $this->log("No OpenImmo XML found in ZIP");
            $this->zipHandler->cleanup($extractDir);
            return false;
        }

        $this->log("Found XML: " . basename($xmlFile));

        // Parse XML
        if (!$this->parser->open($xmlFile)) {
            $this->log("Failed to open XML: " . implode(', ', $this->parser->getErrors()));
            $this->zipHandler->cleanup($extractDir);
            return false;
        }

        // Get transfer info
        $transferInfo = $this->parser->getTransferInfo();
        $provider = $this->parser->getProvider();
        $providerId = $provider['id'] ?? 'default';

        $this->log("Transfer mode: " . ($transferInfo['umfang'] ?? 'unknown'));
        $this->log("Provider: {$providerId}");

        // Reset mapper stats
        $this->mapper->resetStats();

        // Track processed external IDs for VOLL transfers
        $processedIds = [];

        // Process properties
        foreach ($this->parser->getProperties() as $propertyData) {
            $externalId = $propertyData['external_id'];

            if ($externalId) {
                $processedIds[] = $externalId;
            }

            // Sync property to database
            $this->mapper->sync($propertyData, $providerId);

            // Process images
            if (!empty($propertyData['images'])) {
                $images = $this->mediaProcessor->processImages(
                    $extractDir,
                    $externalId,
                    $propertyData['images']
                );

                $mainImage = !empty($images) ? $images[0] : null;
                $this->mapper->updateImages($externalId, $providerId, $mainImage, $images);
            }
        }

        // For VOLL transfers, mark missing properties as sold
        if ($this->parser->isFullTransfer() && !empty($processedIds)) {
            $deletedCount = $this->mapper->markMissingAsSold($processedIds, $providerId);
            $this->log("Marked {$deletedCount} missing properties as sold");
        }

        // Cleanup
        $this->parser->close();
        $this->zipHandler->cleanup($extractDir);
        $this->zipHandler->archive($zipPath);

        $stats = $this->mapper->getStats();
        $this->log("Completed: +{$stats['inserted']} / ~{$stats['updated']} / -{$stats['deleted']}");

        return true;
    }

    /**
     * Add a log entry.
     */
    protected function log(string $message): void
    {
        $this->logs[] = [
            'time' => date('Y-m-d H:i:s'),
            'message' => $message,
        ];

        // Also log to CodeIgniter logger
        log_message('info', "[OpenImmo] {$message}");
    }

    /**
     * Save import log to database for admin viewing.
     */
    protected function saveImportLog(array $stats, float $duration): void
    {
        $logPath = WRITEPATH . 'logs/openimmo_imports.log';

        $logEntry = sprintf(
            "[%s] Duration: %.2fs | Inserted: %d | Updated: %d | Deleted: %d | Errors: %d\n",
            date('Y-m-d H:i:s'),
            $duration,
            $stats['inserted'],
            $stats['updated'],
            $stats['deleted'],
            count($stats['errors'])
        );

        file_put_contents($logPath, $logEntry, FILE_APPEND);
    }

    /**
     * Manual trigger endpoint (requires auth).
     */
    public function trigger(): ResponseInterface
    {
        return $this->process();
    }

    /**
     * Show import status and logs.
     */
    public function status(): ResponseInterface
    {
        $logPath = WRITEPATH . 'logs/openimmo_imports.log';
        $logs = [];

        if (file_exists($logPath)) {
            $logs = array_slice(file($logPath, FILE_IGNORE_NEW_LINES), -20);
        }

        $pendingFiles = $this->zipHandler->getPendingFiles();

        return $this->response->setJSON([
            'pending_files' => count($pendingFiles),
            'import_directory' => $this->zipHandler->getImportDir(),
            'recent_logs' => array_reverse($logs),
        ]);
    }
}
