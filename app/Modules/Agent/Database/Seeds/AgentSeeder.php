<?php

namespace App\Modules\Agent\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AgentSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('agents')->truncate();

        $agents = [
            [
                'name' => 'John Doe',
                'slug' => 'john-doe',
                'title' => 'Senior Real Estate Agent',
                'bio' => 'John has been in the real estate industry for over 15 years and has a passion for helping clients find their perfect home.',
                'photo' => 'https://via.placeholder.com/150/2563eb/ffffff?text=John+D',
                'phone' => '123-456-7890',
                'email' => 'john.doe@ckrealestate.com',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Jane Smith',
                'slug' => 'jane-smith',
                'title' => 'Luxury Property Specialist',
                'bio' => 'Jane specializes in high-end properties and has a keen eye for detail and luxury.',
                'photo' => 'https://via.placeholder.com/150/0f172a/ffffff?text=Jane+S',
                'phone' => '123-456-7891',
                'email' => 'jane.smith@ckrealestate.com',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
             [
                'name' => 'Mike Johnson',
                'slug' => 'mike-johnson',
                'title' => 'Commercial Real Estate Agent',
                'bio' => 'Mike is an expert in commercial properties, helping businesses find the perfect space to grow.',
                'photo' => 'https://via.placeholder.com/150/2563eb/ffffff?text=Mike+J',
                'phone' => '123-456-7892',
                'email' => 'mike.johnson@ckrealestate.com',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($agents as $agent) {
            $this->db->table('agents')->insert($agent);
        }
    }
}
