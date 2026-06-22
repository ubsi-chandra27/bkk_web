<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbJenisBerkas extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `tb_jenis_berkas` (
                `id_jenis_berkas` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `nama_berkas` varchar(100) NOT NULL,
                `slug_berkas` varchar(50) NOT NULL,
                `berlaku_untuk` enum('semua','alumni','umum') NOT NULL DEFAULT 'semua',
                `keterangan` text DEFAULT NULL,
                `status_aktif` tinyint(1) NOT NULL DEFAULT 1,
                `dibuat_pada` datetime DEFAULT NULL,
                `diperbarui_pada` datetime DEFAULT NULL,
                PRIMARY KEY (`id_jenis_berkas`),
                UNIQUE KEY `slug_berkas` (`slug_berkas`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ");
    }

    public function down()
    {
        $this->forge->dropTable('tb_jenis_berkas', true);
    }
}
