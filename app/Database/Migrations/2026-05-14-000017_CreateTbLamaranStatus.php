<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbLamaranStatus extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `tb_lamaran_status` (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_lamaran` int(10) UNSIGNED NOT NULL,
                `status_lama` enum('menunggu_diverifikasi','diproses','lolos_verifikasi','wawancara','tidak_lolos','diterima') DEFAULT NULL,
                `status_baru` enum('menunggu_diverifikasi','diproses','lolos_verifikasi','wawancara','tidak_lolos','diterima') NOT NULL,
                `catatan` text DEFAULT NULL,
                `diubah_oleh` int(10) UNSIGNED DEFAULT NULL COMMENT 'Otomatis dari sesi login',
                `created_at` datetime DEFAULT current_timestamp(),
                PRIMARY KEY (`id`),
                KEY `id_lamaran` (`id_lamaran`),
                KEY `diubah_oleh` (`diubah_oleh`),
                CONSTRAINT `tb_lamaran_status_ibfk_1` FOREIGN KEY (`id_lamaran`) REFERENCES `tb_lamaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `tb_lamaran_status_ibfk_2` FOREIGN KEY (`diubah_oleh`) REFERENCES `tb_users` (`id`) ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Riwayat perubahan status lamaran'
        ");
    }

    public function down()
    {
        $this->forge->dropTable('tb_lamaran_status', true);
    }
}
