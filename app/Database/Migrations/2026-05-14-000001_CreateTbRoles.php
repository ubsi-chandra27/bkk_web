<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbRoles extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `tb_roles` (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `nama_role` varchar(50) NOT NULL COMMENT 'super_admin, admin_bkk, admin_dudi, pelamar_alumni, pelamar_umum',
                `created_at` datetime DEFAULT current_timestamp(),
                `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Master role pengguna'
        ");
    }

    public function down()
    {
        $this->forge->dropTable('tb_roles', true);
    }
}
