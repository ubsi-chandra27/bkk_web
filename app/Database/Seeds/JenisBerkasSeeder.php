<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JenisBerkasSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $jenisBerkas = [
            [
                'id_jenis_berkas' => 1,
                'nama_berkas' => 'CV / Resume',
                'slug_berkas' => 'cv',
                'berlaku_untuk' => 'semua',
                'keterangan' => 'Curriculum vitae atau resume pelamar',
                'status_aktif' => 1,
                'dibuat_pada' => $now,
                'diperbarui_pada' => $now,
            ],
            [
                'id_jenis_berkas' => 2,
                'nama_berkas' => 'Surat Lamaran',
                'slug_berkas' => 'surat_lamaran',
                'berlaku_untuk' => 'semua',
                'keterangan' => 'Surat lamaran kerja berdasarkan lowongan',
                'status_aktif' => 1,
                'dibuat_pada' => $now,
                'diperbarui_pada' => $now,
            ],
            [
                'id_jenis_berkas' => 3,
                'nama_berkas' => 'Ijazah',
                'slug_berkas' => 'ijazah',
                'berlaku_untuk' => 'semua',
                'keterangan' => 'Ijazah terakhir',
                'status_aktif' => 1,
                'dibuat_pada' => $now,
                'diperbarui_pada' => $now,
            ],
            [
                'id_jenis_berkas' => 4,
                'nama_berkas' => 'KTP',
                'slug_berkas' => 'ktp',
                'berlaku_untuk' => 'semua',
                'keterangan' => 'Kartu Tanda Penduduk',
                'status_aktif' => 1,
                'dibuat_pada' => $now,
                'diperbarui_pada' => $now,
            ],
            [
                'id_jenis_berkas' => 5,
                'nama_berkas' => 'SKCK',
                'slug_berkas' => 'skck',
                'berlaku_untuk' => 'semua',
                'keterangan' => 'Surat Keterangan Catatan Kepolisian',
                'status_aktif' => 1,
                'dibuat_pada' => $now,
                'diperbarui_pada' => $now,
            ],
            [
                'id_jenis_berkas' => 6,
                'nama_berkas' => 'Portofolio',
                'slug_berkas' => 'porto',
                'berlaku_untuk' => 'semua',
                'keterangan' => 'Portofolio pelamar',
                'status_aktif' => 1,
                'dibuat_pada' => $now,
                'diperbarui_pada' => $now,
            ],
        ];

        foreach ($jenisBerkas as $row) {
            $this->db->table('tb_jenis_berkas')->replace($row);
        }
    }
}
