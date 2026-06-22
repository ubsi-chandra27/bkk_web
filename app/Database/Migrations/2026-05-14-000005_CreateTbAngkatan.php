<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbAngkatan extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `tb_angkatan` (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `tahun` year(4) NOT NULL COMMENT 'Tahun lulus',
                `is_active` tinyint(1) NOT NULL DEFAULT 1,
                `created_at` datetime DEFAULT current_timestamp(),
                `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Master tahun angkatan/lulus'
        ");
    }

    public function down()
    {
        $this->forge->dropTable('tb_angkatan', true);
    }
}
