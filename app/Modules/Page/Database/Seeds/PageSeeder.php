<?php

namespace App\Modules\Page\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('pages')->truncate();

        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about',
                'content' => '<p>This is the full content for the About Us page...</p>',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact',
                'content' => '<p>This is the placeholder content for the Contact Us page...</p>',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($pages as $page) {
            $this->db->table('pages')->insert($page);
        }
    }
}
