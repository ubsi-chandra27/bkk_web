<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbMou extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `tb_mou` (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_perusahaan` int(10) UNSIGNED NOT NULL,
                `id_kerjasama` int(10) UNSIGNED NOT NULL,
                `nomor_mou` varchar(100) DEFAULT NULL,
                `tanggal_mou` date DEFAULT NULL,
                `tanggal_berlaku` date DEFAULT NULL,
                `tanggal_berakhir` date DEFAULT NULL,
                `file_mou` varchar(255) DEFAULT NULL COMMENT 'Upload scan/PDF dokumen MOU',
                `status` enum('aktif','berakhir','diperpanjang') NOT NULL DEFAULT 'aktif',
                `created_by` int(10) UNSIGNED DEFAULT NULL COMMENT 'Otomatis dari sesi login',
                `created_at` datetime DEFAULT current_timestamp(),
                `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`),
                KEY `id_perusahaan` (`id_perusahaan`),
                KEY `id_kerjasama` (`id_kerjasama`),
                KEY `created_by` (`created_by`),
                CONSTRAINT `tb_mou_ibfk_1` FOREIGN KEY (`id_perusahaan`) REFERENCES `tb_perusahaan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `tb_mou_ibfk_2` FOREIGN KEY (`id_kerjasama`) REFERENCES `tb_kerjasama` (`id`) ON UPDATE CASCADE,
                CONSTRAINT `tb_mou_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `tb_users` (`id`) ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='MOU/perjanjian kerjasama sekolah dengan DUDI'
        ");
    }

    public function down()
    {
        $this->forge->dropTable('tb_mou', true);
    }
}
