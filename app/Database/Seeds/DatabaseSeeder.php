<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('RolesSeeder');
        $this->call('UsersSeeder');
        $this->call('AktivitasSeeder');
        $this->call('JurusanAngkatanSeeder');
        $this->call('JenisBerkasSeeder');
    }
}
