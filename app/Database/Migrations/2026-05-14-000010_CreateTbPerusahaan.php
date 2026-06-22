<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbPerusahaan extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `tb_perusahaan` (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_user` int(10) UNSIGNED DEFAULT NULL COMMENT 'Diisi setelah akun Admin DUDI dibuat',
                `nama_perusahaan` varchar(150) NOT NULL,
                `bidang_usaha` varchar(100) DEFAULT NULL,
                `alamat` text DEFAULT NULL,
                `kota` varchar(100) DEFAULT NULL,
                `no_telepon` varchar(20) DEFAULT NULL,
                `email` varchar(100) DEFAULT NULL,
                `website` varchar(150) DEFAULT NULL,
                `logo` varchar(255) DEFAULT NULL,
                `is_active` tinyint(1) NOT NULL DEFAULT 1,
                `created_at` datetime DEFAULT current_timestamp(),
                `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`),
                KEY `id_user` (`id_user`),
                CONSTRAINT `tb_perusahaan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_users` (`id`) ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Data perusahaan/DUDI mitra sekolah'
        ");
    }

    public function down()
    {
        $this->forge->dropTable('tb_perusahaan', true);
    }
}
