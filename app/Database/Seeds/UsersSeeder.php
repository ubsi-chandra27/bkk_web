<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $users = [
            [
                'id' => 1,
                'id_role' => 1,
                'nama' => 'Super Admin',
                'email' => 'admin@bkk.test',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'remember_token' => null,
                'is_active' => 1,
                'last_login' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'id_role' => 2,
                'nama' => 'Admin BKK',
                'email' => 'operator@bkk.test',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'remember_token' => null,
                'is_active' => 1,
                'last_login' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'id_role' => 3,
                'nama' => 'Admin DUDI',
                'email' => 'dudi@bkk.test',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'remember_token' => null,
                'is_active' => 1,
                'last_login' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'id_role' => 4,
                'nama' => 'Alumni Demo',
                'email' => 'alumni@bkk.test',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'remember_token' => null,
                'is_active' => 1,
                'last_login' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'id_role' => 5,
                'nama' => 'Pelamar Umum Demo',
                'email' => 'pelamar@bkk.test',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'remember_token' => null,
                'is_active' => 1,
                'last_login' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($users as $user) {
            $this->db->table('tb_users')->replace($user);
        }
    }
}
