<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AktivitasSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $aktivitas = [
            ['id' => 1, 'nama_aktivitas' => 'Bekerja', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'nama_aktivitas' => 'Kuliah', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'nama_aktivitas' => 'Wirausaha', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'nama_aktivitas' => 'Mencari Kerja', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'nama_aktivitas' => 'Berencana Kuliah', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($aktivitas as $row) {
            $this->db->table('tb_aktivitas')->replace($row);
        }
    }
}
