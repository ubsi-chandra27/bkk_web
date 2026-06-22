<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbLowongan extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `tb_lowongan` (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_perusahaan` int(10) UNSIGNED NOT NULL,
                `posisi` varchar(100) NOT NULL COMMENT 'Nama jabatan: Staff IT, HRD, dll',
                `gaji` varchar(100) NOT NULL,
                `deskripsi_pekerjaan` text DEFAULT NULL,
                `kualifikasi` text DEFAULT NULL,
                `jenis_pekerjaan` enum('fulltime','parttime','magang','kontrak') NOT NULL,
                `lokasi_kerja` varchar(150) DEFAULT NULL,
                `batas_lamaran` date DEFAULT NULL,
                `status` enum('draft','aktif','ditutup','kadaluarsa') NOT NULL DEFAULT 'aktif',
                `dibuat_oleh` int(10) UNSIGNED DEFAULT NULL COMMENT 'Otomatis dari sesi login',
                `created_at` datetime DEFAULT current_timestamp(),
                `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`),
                KEY `id_perusahaan` (`id_perusahaan`),
                KEY `dibuat_oleh` (`dibuat_oleh`),
                CONSTRAINT `tb_lowongan_ibfk_1` FOREIGN KEY (`id_perusahaan`) REFERENCES `tb_perusahaan` (`id`) ON UPDATE CASCADE,
                CONSTRAINT `tb_lowongan_ibfk_2` FOREIGN KEY (`dibuat_oleh`) REFERENCES `tb_users` (`id`) ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Data lowongan kerja dari DUDI'
        ");
    }

    public function down()
    {
        $this->forge->dropTable('tb_lowongan', true);
    }
}
