<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbJurusan extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `tb_jurusan` (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `kompetensi_keahlian` varchar(150) NOT NULL,
                `akronim` varchar(20) DEFAULT NULL,
                `is_active` tinyint(1) NOT NULL DEFAULT 1,
                `created_at` datetime DEFAULT current_timestamp(),
                `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Master kompetensi keahlian/jurusan'
        ");
    }

    public function down()
    {
        $this->forge->dropTable('tb_jurusan', true);
    }
}
