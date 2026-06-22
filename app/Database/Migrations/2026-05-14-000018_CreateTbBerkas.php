<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbBerkas extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `tb_berkas` (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_pelamar` int(10) UNSIGNED NOT NULL,
                `id_jenis_berkas` int(10) UNSIGNED NOT NULL DEFAULT 0,
                `nama_file` varchar(255) DEFAULT NULL,
                `path_file` varchar(255) DEFAULT NULL,
                `status` enum('belum','pending','valid','ditolak') DEFAULT 'belum',
                `created_at` datetime DEFAULT current_timestamp(),
                `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`),
                KEY `id_pelamar` (`id_pelamar`),
                KEY `id_jenis_berkas` (`id_jenis_berkas`),
                CONSTRAINT `tb_berkas_ibfk_1` FOREIGN KEY (`id_pelamar`) REFERENCES `tb_pelamar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `tb_berkas_ibfk_2` FOREIGN KEY (`id_jenis_berkas`) REFERENCES `tb_jenis_berkas` (`id_jenis_berkas`) ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Dokumen/berkas upload pelamar'
        ");
    }

    public function down()
    {
        $this->forge->dropTable('tb_berkas', true);
    }
}
