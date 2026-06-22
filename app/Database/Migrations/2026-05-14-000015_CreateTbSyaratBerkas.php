<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbSyaratBerkas extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `tb_syarat_berkas` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `id_lowongan` int(10) UNSIGNED NOT NULL,
                `id_jenis_berkas` int(10) UNSIGNED NOT NULL,
                `wajib` tinyint(1) NOT NULL DEFAULT 1,
                PRIMARY KEY (`id`),
                KEY `tb_syarat_berkas_id_lowongan_foreign` (`id_lowongan`),
                KEY `tb_syarat_berkas_id_jenis_berkas_foreign` (`id_jenis_berkas`),
                CONSTRAINT `tb_syarat_berkas_id_jenis_berkas_foreign` FOREIGN KEY (`id_jenis_berkas`) REFERENCES `tb_jenis_berkas` (`id_jenis_berkas`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `tb_syarat_berkas_id_lowongan_foreign` FOREIGN KEY (`id_lowongan`) REFERENCES `tb_lowongan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ");
    }

    public function down()
    {
        $this->forge->dropTable('tb_syarat_berkas', true);
    }
}
