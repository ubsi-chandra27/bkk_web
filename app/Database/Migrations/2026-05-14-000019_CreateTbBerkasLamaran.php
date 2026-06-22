<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbBerkasLamaran extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `tb_berkas_lamaran` (
                `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_lamaran` int(10) UNSIGNED NOT NULL,
                `id_jenis_berkas` int(10) UNSIGNED NOT NULL,
                `file_path` varchar(500) NOT NULL,
                `file_name` varchar(255) NOT NULL,
                `file_size` int(11) UNSIGNED DEFAULT NULL COMMENT 'Ukuran file dalam bytes',
                `uploaded_at` datetime DEFAULT NULL,
                `created_at` datetime DEFAULT NULL,
                `updated_at` datetime DEFAULT NULL,
                `deleted_at` datetime DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `tb_berkas_lamaran_id_lamaran_foreign` (`id_lamaran`),
                KEY `tb_berkas_lamaran_id_jenis_berkas_foreign` (`id_jenis_berkas`),
                CONSTRAINT `tb_berkas_lamaran_id_jenis_berkas_foreign` FOREIGN KEY (`id_jenis_berkas`) REFERENCES `tb_jenis_berkas` (`id_jenis_berkas`),
                CONSTRAINT `tb_berkas_lamaran_id_lamaran_foreign` FOREIGN KEY (`id_lamaran`) REFERENCES `tb_lamaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ");
    }

    public function down()
    {
        $this->forge->dropTable('tb_berkas_lamaran', true);
    }
}
