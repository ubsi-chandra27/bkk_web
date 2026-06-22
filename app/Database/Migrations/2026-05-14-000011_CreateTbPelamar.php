<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbPelamar extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `tb_pelamar` (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_user` int(10) UNSIGNED NOT NULL,
                `account_id` varchar(20) NOT NULL COMMENT 'Format: PLM-202603300001',
                `jenis_pelamar` enum('alumni','umum') NOT NULL,
                `telepon` varchar(20) DEFAULT NULL,
                `foto` varchar(255) DEFAULT NULL,
                `jenis_kelamin` enum('L','P') DEFAULT NULL,
                `tempat_lahir` varchar(100) DEFAULT NULL,
                `tanggal_lahir` date DEFAULT NULL,
                `alamat` text DEFAULT NULL,
                `nomer_nik` varchar(20) DEFAULT NULL,
                `status_pendaftaran` enum('menunggu_aktivasi','aktif','terdaftar') NOT NULL DEFAULT 'menunggu_aktivasi',
                `terdaftar_pada` datetime DEFAULT NULL,
                `diaktivasi_oleh` int(10) UNSIGNED DEFAULT NULL,
                `diaktivasi_pada` datetime DEFAULT NULL,
                `created_at` datetime DEFAULT current_timestamp(),
                `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`),
                UNIQUE KEY `account_id` (`account_id`),
                KEY `id_user` (`id_user`),
                CONSTRAINT `tb_pelamar_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Profil detail pelamar (alumni & umum)'
        ");
    }

    public function down()
    {
        $this->forge->dropTable('tb_pelamar', true);
    }
}
