<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $roles = [
            ['id' => 1, 'nama_role' => 'Super Admin', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'nama_role' => 'Admin BKK', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'nama_role' => 'Admin DUDI', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'nama_role' => 'Pelamar Alumni', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'nama_role' => 'Pelamar Umum', 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($roles as $role) {
            $this->db->table('tb_roles')->replace($role);
        }
    }
}
