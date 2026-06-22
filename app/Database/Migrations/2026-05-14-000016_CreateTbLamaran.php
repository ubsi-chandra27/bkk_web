<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbLamaran extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `tb_lamaran` (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_pelamar` int(10) UNSIGNED NOT NULL,
                `id_lowongan` int(10) UNSIGNED NOT NULL,
                `tanggal_melamar` datetime NOT NULL DEFAULT current_timestamp(),
                `tanggal_wawancara` datetime DEFAULT NULL,
                `status` enum('menunggu_diverifikasi','diproses','lolos_verifikasi','wawancara','tidak_lolos','diterima') NOT NULL DEFAULT 'menunggu_diverifikasi',
                `catatan` text DEFAULT NULL,
                `dibuat_oleh` int(10) UNSIGNED DEFAULT NULL COMMENT 'Otomatis dari sesi login',
                `created_at` datetime DEFAULT current_timestamp(),
                `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`),
                KEY `id_pelamar` (`id_pelamar`),
                KEY `id_lowongan` (`id_lowongan`),
                KEY `dibuat_oleh` (`dibuat_oleh`),
                CONSTRAINT `tb_lamaran_ibfk_1` FOREIGN KEY (`id_pelamar`) REFERENCES `tb_pelamar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `tb_lamaran_ibfk_2` FOREIGN KEY (`id_lowongan`) REFERENCES `tb_lowongan` (`id`) ON UPDATE CASCADE,
                CONSTRAINT `tb_lamaran_ibfk_3` FOREIGN KEY (`dibuat_oleh`) REFERENCES `tb_users` (`id`) ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Data lamaran kerja pelamar'
        ");
    }

    public function down()
    {
        $this->forge->dropTable('tb_lamaran', true);
    }
}
