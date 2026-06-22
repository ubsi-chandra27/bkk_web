<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbAlumni extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `tb_alumni` (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_pelamar` int(10) UNSIGNED NOT NULL,
                `id_angkatan` int(10) UNSIGNED DEFAULT NULL,
                `id_jurusan` int(10) UNSIGNED DEFAULT NULL,
                `nis` varchar(20) DEFAULT NULL,
                `nisn` varchar(20) DEFAULT NULL,
                `no_ijazah` varchar(50) DEFAULT NULL,
                `is_verifikasi` tinyint(1) NOT NULL DEFAULT 0,
                `created_at` datetime DEFAULT current_timestamp(),
                `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`),
                KEY `id_pelamar` (`id_pelamar`),
                KEY `id_angkatan` (`id_angkatan`),
                KEY `id_jurusan` (`id_jurusan`),
                CONSTRAINT `tb_alumni_ibfk_1` FOREIGN KEY (`id_pelamar`) REFERENCES `tb_pelamar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `tb_alumni_ibfk_2` FOREIGN KEY (`id_angkatan`) REFERENCES `tb_angkatan` (`id`) ON UPDATE CASCADE,
                CONSTRAINT `tb_alumni_ibfk_3` FOREIGN KEY (`id_jurusan`) REFERENCES `tb_jurusan` (`id`) ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Data khusus pelamar alumni'
        ");
    }

    public function down()
    {
        $this->forge->dropTable('tb_alumni', true);
    }
}
