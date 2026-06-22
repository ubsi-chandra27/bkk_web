<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbAdmin extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `tb_admin` (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_user` int(10) UNSIGNED NOT NULL,
                `jenis_kelamin` enum('L','P') DEFAULT NULL,
                `tempat_lahir` varchar(100) DEFAULT NULL,
                `tanggal_lahir` date DEFAULT NULL,
                `telepon` varchar(20) DEFAULT NULL,
                `alamat` text DEFAULT NULL,
                `foto` varchar(255) DEFAULT NULL,
                `created_at` datetime DEFAULT current_timestamp(),
                `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`),
                KEY `id_user` (`id_user`),
                CONSTRAINT `tb_admin_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Profil detail admin (BKK & DUDI)'
        ");
    }

    public function down()
    {
        $this->forge->dropTable('tb_admin', true);
    }
}
