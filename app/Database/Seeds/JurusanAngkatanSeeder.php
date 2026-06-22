<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JurusanAngkatanSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $jurusan = [
            ['id' => 1, 'kompetensi_keahlian' => 'Teknik Komputer dan Jaringan', 'akronim' => 'TKJ', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'kompetensi_keahlian' => 'Rekayasa Perangkat Lunak', 'akronim' => 'RPL', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'kompetensi_keahlian' => 'Multimedia', 'akronim' => 'MM', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'kompetensi_keahlian' => 'Akuntansi dan Keuangan Lembaga', 'akronim' => 'AKL', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'kompetensi_keahlian' => 'Otomatisasi dan Tata Kelola Perkantoran', 'akronim' => 'OTKP', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ];

        $angkatan = [
            ['id' => 1, 'tahun' => '2021', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'tahun' => '2022', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'tahun' => '2023', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'tahun' => '2024', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'tahun' => '2025', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($jurusan as $row) {
            $this->db->table('tb_jurusan')->replace($row);
        }

        foreach ($angkatan as $row) {
            $this->db->table('tb_angkatan')->replace($row);
        }
    }
}
