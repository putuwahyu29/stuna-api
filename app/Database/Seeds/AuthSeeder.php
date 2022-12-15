<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AuthSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'superadmin',
                'password' => password_hash('superadmin', PASSWORD_DEFAULT),
                'role_id' => 1
            ],
            [
                'username' => 'admin',
                'password' => password_hash('admin', PASSWORD_DEFAULT),
                'role_id' => 2
            ],
            [
                'username' => 'user',
                'password' => password_hash('user', PASSWORD_DEFAULT),
                'role_id' => 3
            ],
        ];
        $this->db->table('auth')->insertBatch($data);
    }
}
