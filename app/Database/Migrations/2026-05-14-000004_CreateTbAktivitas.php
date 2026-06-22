<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbAktivitas extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `tb_aktivitas` (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `nama_aktivitas` varchar(100) NOT NULL COMMENT 'Bekerja, Kuliah, Wirausaha, Belum Bekerja',
                `is_active` tinyint(1) NOT NULL DEFAULT 1,
                `created_at` datetime DEFAULT current_timestamp(),
                `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Master status aktivitas alumni untuk tracer study'
        ");
    }

    public function down()
    {
        $this->forge->dropTable('tb_aktivitas', true);
    }
}
