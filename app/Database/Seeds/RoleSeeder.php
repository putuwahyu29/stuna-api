<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'ROLE_SUPERADMIN',
            ],
            [
                'name' => 'ROLE_ADMIN',
            ],
            [
                'name' => 'ROLE_USER',
            ],
        ];

        $this->db->table('roles')->insertBatch($data);
    }
}
