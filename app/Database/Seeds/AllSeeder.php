<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AllSeeder extends Seeder
{
    public function run()
    {
        $this->call('RoleSeeder');
        $this->call('KelasSeeder');
        $this->call('AuthSeeder');
        $this->call('UserSeeder');
    }
}