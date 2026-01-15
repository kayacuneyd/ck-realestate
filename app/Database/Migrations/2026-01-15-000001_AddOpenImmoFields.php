<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Add OpenImmo fields to properties table
 * 
 * Extends the properties table to support data from OpenImmo XML imports
 * from Propstack CRM and other OpenImmo-compatible sources.
 */
class AddOpenImmoFields extends Migration
{
    public function up()
    {
        // Add new fields for OpenImmo compatibility
        $this->forge->addColumn('properties', [
            // External reference (unique identifier from source system)
            'external_id' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'id',
            ],
            // Provider/Agency identifier
            'provider_id' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'external_id',
            ],
            // Marketing type: KAUF (buy), MIETE_PACHT (rent)
            'marketing_type' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'default' => 'KAUF',
                'after' => 'type',
            ],
            // Property type: wohnung, haus, buero_praxen, etc.
            'property_type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'marketing_type',
            ],
            // Room count (can be decimal like 2.5)
            'rooms' => [
                'type' => 'DECIMAL',
                'constraint' => '4,1',
                'null' => true,
                'after' => 'bathrooms',
            ],
            // Living area (wohnflaeche) in sqm
            'living_area' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
                'after' => 'area_sqm',
            ],
            // Usable area (nutzflaeche) in sqm
            'usable_area' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
                'after' => 'living_area',
            ],
            // Plot area (grundstuecksflaeche) in sqm
            'plot_area' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
                'after' => 'usable_area',
            ],
            // Geo coordinates
            'latitude' => [
                'type' => 'DECIMAL',
                'constraint' => '10,8',
                'null' => true,
                'after' => 'zip_code',
            ],
            'longitude' => [
                'type' => 'DECIMAL',
                'constraint' => '11,8',
                'null' => true,
                'after' => 'latitude',
            ],
            // Floor information
            'floor' => [
                'type' => 'INT',
                'null' => true,
                'after' => 'longitude',
            ],
            'total_floors' => [
                'type' => 'INT',
                'null' => true,
                'after' => 'floor',
            ],
            // Construction year
            'construction_year' => [
                'type' => 'INT',
                'null' => true,
                'after' => 'total_floors',
            ],
            // Heating type
            'heating_type' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'construction_year',
            ],
            // Energy certificate fields (required by German law)
            'energy_certificate_type' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'heating_type',
            ],
            'energy_value' => [
                'type' => 'DECIMAL',
                'constraint' => '6,2',
                'null' => true,
                'after' => 'energy_certificate_type',
            ],
            'energy_class' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'null' => true,
                'after' => 'energy_value',
            ],
            // Rental costs (for MIETE properties)
            'cold_rent' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'null' => true,
                'after' => 'price',
            ],
            'warm_rent' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'null' => true,
                'after' => 'cold_rent',
            ],
            'additional_costs' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'null' => true,
                'after' => 'warm_rent',
            ],
            'heating_costs' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'null' => true,
                'after' => 'additional_costs',
            ],
            // Deposit and commission
            'deposit' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'heating_costs',
            ],
            'commission' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
                'after' => 'deposit',
            ],
            // Availability
            'available_from' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'commission',
            ],
            // Sync tracking
            'last_sync_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'updated_at',
            ],
            // Raw XML data for debugging
            'openimmo_raw' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'last_sync_at',
            ],
        ]);

        // Add unique index for external_id + provider_id
        $this->db->query('CREATE UNIQUE INDEX idx_external_provider ON properties(external_id, provider_id) WHERE external_id IS NOT NULL');
    }

    public function down()
    {
        // Remove the columns
        $this->forge->dropColumn('properties', [
            'external_id',
            'provider_id',
            'marketing_type',
            'property_type',
            'rooms',
            'living_area',
            'usable_area',
            'plot_area',
            'latitude',
            'longitude',
            'floor',
            'total_floors',
            'construction_year',
            'heating_type',
            'energy_certificate_type',
            'energy_value',
            'energy_class',
            'cold_rent',
            'warm_rent',
            'additional_costs',
            'heating_costs',
            'deposit',
            'commission',
            'available_from',
            'last_sync_at',
            'openimmo_raw',
        ]);
    }
}
