<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbUsers extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `tb_users` (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_role` int(10) UNSIGNED NOT NULL,
                `nama` varchar(100) NOT NULL,
                `email` varchar(100) NOT NULL,
                `password` varchar(255) NOT NULL,
                `remember_token` varchar(100) DEFAULT NULL,
                `is_active` tinyint(1) NOT NULL DEFAULT 1,
                `last_login` datetime DEFAULT NULL,
                `created_at` datetime DEFAULT current_timestamp(),
                `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`),
                UNIQUE KEY `email` (`email`),
                KEY `id_role` (`id_role`),
                CONSTRAINT `tb_users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `tb_roles` (`id`) ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Akun login semua aktor'
        ");
    }

    public function down()
    {
        $this->forge->dropTable('tb_users', true);
    }
}
