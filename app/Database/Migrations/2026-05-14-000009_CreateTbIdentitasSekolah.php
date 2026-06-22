<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbIdentitasSekolah extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `tb_identitas_sekolah` (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `nama_sekolah` varchar(150) NOT NULL,
                `singkatan` varchar(50) DEFAULT NULL,
                `npsn` varchar(20) DEFAULT NULL,
                `nss` varchar(30) DEFAULT NULL,
                `alamat` text DEFAULT NULL,
                `kota` varchar(100) DEFAULT NULL,
                `provinsi` varchar(100) DEFAULT NULL,
                `kode_pos` varchar(10) DEFAULT NULL,
                `no_telepon` varchar(20) DEFAULT NULL,
                `email` varchar(100) DEFAULT NULL,
                `website` varchar(150) DEFAULT NULL,
                `logo` varchar(255) DEFAULT NULL,
                `kepala_sekolah` varchar(150) DEFAULT NULL,
                `nip_kepala_sekolah` varchar(30) DEFAULT NULL,
                `akreditasi` enum('A','B','C','Belum') DEFAULT NULL,
                `tahun_akreditasi` year(4) DEFAULT NULL,
                `created_at` datetime DEFAULT current_timestamp(),
                `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Identitas sekolah - hanya 1 baris data'
        ");
    }

    public function down()
    {
        $this->forge->dropTable('tb_identitas_sekolah', true);
    }
}
