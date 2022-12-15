<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'superadmin',
                'fullName' => 'Super Admin',
                'email' => 'superadmin@localhost.test',
                'kelas_id' => 49,
                'nama_panggilan' => 'Super Admin',
            ],
            [
                'username' => 'admin',
                'fullName' => 'Admin',
                'email' => 'admin@localhost.test',
                'kelas_id' => 49,
                'nama_panggilan' => 'Admin',
            ],
            [
                'username' => 'user',
                'fullName' => 'User',
                'email' => 'user@localhost.test',
                'kelas_id' => 49,
                'nama_panggilan' => 'User',
            ],
        ];
        $this->db->table('user')->insertBatch($data);
    }
}
