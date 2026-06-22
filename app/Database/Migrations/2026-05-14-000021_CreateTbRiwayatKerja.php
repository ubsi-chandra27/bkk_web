<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbRiwayatKerja extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `tb_riwayat_kerja` (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_pelamar` int(10) UNSIGNED NOT NULL,
                `nama_perusahaan` varchar(150) NOT NULL,
                `posisi_jabatan` varchar(100) DEFAULT NULL,
                `tanggal_mulai` date DEFAULT NULL,
                `tanggal_selesai` date DEFAULT NULL,
                `is_masih_bekerja` tinyint(1) NOT NULL DEFAULT 0,
                `deskripsi_kerja` text DEFAULT NULL,
                `created_at` datetime DEFAULT current_timestamp(),
                `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`),
                KEY `id_pelamar` (`id_pelamar`),
                CONSTRAINT `tb_riwayat_kerja_ibfk_1` FOREIGN KEY (`id_pelamar`) REFERENCES `tb_pelamar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Riwayat pengalaman kerja pelamar sebelumnya'
        ");
    }

    public function down()
    {
        $this->forge->dropTable('tb_riwayat_kerja', true);
    }
}
