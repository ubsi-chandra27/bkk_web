<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbLowonganJurusan extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `tb_lowongan_jurusan` (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_lowongan` int(10) UNSIGNED NOT NULL,
                `id_jurusan` int(10) UNSIGNED NOT NULL,
                `created_at` datetime DEFAULT current_timestamp(),
                PRIMARY KEY (`id`),
                KEY `id_lowongan` (`id_lowongan`),
                KEY `id_jurusan` (`id_jurusan`),
                CONSTRAINT `tb_lowongan_jurusan_ibfk_1` FOREIGN KEY (`id_lowongan`) REFERENCES `tb_lowongan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `tb_lowongan_jurusan_ibfk_2` FOREIGN KEY (`id_jurusan`) REFERENCES `tb_jurusan` (`id`) ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Relasi lowongan dengan jurusan yang dituju'
        ");
    }

    public function down()
    {
        $this->forge->dropTable('tb_lowongan_jurusan', true);
    }
}
