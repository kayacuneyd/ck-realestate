<?php

namespace App\Modules\Property\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTypeAndMainImageToProperties extends Migration
{
    public function up()
    {
        $this->forge->addColumn('properties', [
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'sale',
            ],
            'main_image_url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('properties', ['type', 'main_image_url']);
    }
}
