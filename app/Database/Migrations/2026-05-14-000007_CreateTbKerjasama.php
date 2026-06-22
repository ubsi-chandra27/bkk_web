<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbKerjasama extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `tb_kerjasama` (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `nama_kerjasama` varchar(150) NOT NULL COMMENT 'PKL, Kunjungan Industri, Penguji UKK, dll',
                `created_at` datetime DEFAULT current_timestamp(),
                `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Master jenis kerjasama dengan DUDI'
        ");
    }

    public function down()
    {
        $this->forge->dropTable('tb_kerjasama', true);
    }
}
