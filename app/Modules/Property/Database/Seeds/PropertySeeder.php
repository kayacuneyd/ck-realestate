<?php

namespace App\Modules\Property\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run()
    {
        // To prevent duplicate entries, truncate the table first.
        $this->db->table('properties')->truncate();

        $properties = [
            [
                'title' => 'Modern Downtown Loft',
                'slug' => 'modern-downtown-loft',
                'description' => 'A beautiful and spacious loft in the heart of the city. Features high ceilings, large windows, and a modern kitchen.',
                'price' => 450000.00,
                'bedrooms' => 2,
                'bathrooms' => 2,
                'area_sqm' => 110.00,
                'address' => '123 Main St, Suite 800',
                'city' => 'Capital City',
                'zip_code' => '12345',
                'status' => 'available',
                'featured' => 1,
                'type' => 'sale',
                'main_image_url' => 'https://via.placeholder.com/700x400/2563eb/ffffff?text=Modern+Loft',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Suburban Family Home',
                'slug' => 'suburban-family-home',
                'description' => 'Perfect for families, with a large backyard, quiet neighborhood, and close to excellent schools.',
                'price' => 620000.00,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area_sqm' => 220.00,
                'address' => '456 Oak Avenue',
                'city' => 'Maplewood',
                'zip_code' => '54321',
                'status' => 'available',
                'featured' => 1,
                'type' => 'sale',
                'main_image_url' => 'https://via.placeholder.com/700x400/0f172a/ffffff?text=Family+Home',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Luxury Beachfront Villa',
                'slug' => 'luxury-beachfront-villa',
                'description' => 'Stunning ocean views and direct access to a private beach. Includes a pool and a large patio for entertaining.',
                'price' => 1750000.00,
                'bedrooms' => 5,
                'bathrooms' => 5,
                'area_sqm' => 450.00,
                'address' => '789 Ocean Drive',
                'city' => 'Sunset Bay',
                'zip_code' => '98765',
                'status' => 'available',
                'featured' => 1,
                'type' => 'sale',
                'main_image_url' => 'https://via.placeholder.com/700x400/2563eb/ffffff?text=Beachfront+Villa',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
             [
                'title' => 'Cozy Studio Apartment',
                'slug' => 'cozy-studio-apartment',
                'description' => 'A charming and affordable studio in a vibrant neighborhood, perfect for a single professional or student.',
                'price' => 1200.00,
                'bedrooms' => 0,
                'bathrooms' => 1,
                'area_sqm' => 40.00,
                'address' => '321 City Park Rd',
                'city' => 'Capital City',
                'zip_code' => '12347',
                'status' => 'available',
                'featured' => 0,
                'type' => 'rent',
                'main_image_url' => 'https://via.placeholder.com/700x400/0f172a/ffffff?text=Studio+Apt',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($properties as $property) {
            $this->db->table('properties')->insert($property);
        }
    }
}
