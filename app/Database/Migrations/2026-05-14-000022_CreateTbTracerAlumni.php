<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbTracerAlumni extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `tb_tracer_alumni` (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_alumni` int(10) UNSIGNED NOT NULL,
                `id_aktivitas` int(10) UNSIGNED DEFAULT NULL,
                `status` enum('draft','terkirim','terverifikasi','disetujui') NOT NULL DEFAULT 'draft',
                `diverifikasi_oleh` int(10) UNSIGNED DEFAULT NULL COMMENT 'FK ke tb_users (Admin BKK / Super Admin)',
                `diverifikasi_at` datetime DEFAULT NULL,
                `disetujui_oleh` int(10) UNSIGNED DEFAULT NULL COMMENT 'FK ke tb_users (Super Admin / Admin BKK)',
                `disetujui_at` datetime DEFAULT NULL,
                `posisi_kerja` varchar(100) DEFAULT NULL,
                `nama_dudi` varchar(150) DEFAULT NULL,
                `bidang_dudi` varchar(100) DEFAULT NULL,
                `alamat_dudi` text DEFAULT NULL,
                `tahun_mulai_kerja` year(4) DEFAULT NULL,
                `is_relevan_jurusan` tinyint(1) DEFAULT NULL,
                `penghasilan_range` varchar(50) DEFAULT NULL,
                `universitas` varchar(150) DEFAULT NULL,
                `program_studi` varchar(100) DEFAULT NULL,
                `status_kuliah` varchar(50) DEFAULT NULL,
                `nama_usaha` varchar(150) DEFAULT NULL,
                `bidang_usaha` varchar(100) DEFAULT NULL,
                `modal_awal` decimal(15,2) DEFAULT NULL,
                `penghasilan_usaha` varchar(50) DEFAULT NULL,
                `rencana_universitas` varchar(150) DEFAULT NULL,
                `rencana_prodi` varchar(100) DEFAULT NULL,
                `created_at` datetime DEFAULT current_timestamp(),
                `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`),
                KEY `id_alumni` (`id_alumni`),
                KEY `id_aktivitas` (`id_aktivitas`),
                KEY `diverifikasi_oleh` (`diverifikasi_oleh`),
                KEY `disetujui_oleh` (`disetujui_oleh`),
                CONSTRAINT `tb_tracer_alumni_ibfk_1` FOREIGN KEY (`id_alumni`) REFERENCES `tb_alumni` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `tb_tracer_alumni_ibfk_2` FOREIGN KEY (`id_aktivitas`) REFERENCES `tb_aktivitas` (`id`) ON UPDATE CASCADE,
                CONSTRAINT `tb_tracer_alumni_ibfk_3` FOREIGN KEY (`diverifikasi_oleh`) REFERENCES `tb_users` (`id`) ON UPDATE CASCADE,
                CONSTRAINT `tb_tracer_alumni_ibfk_4` FOREIGN KEY (`disetujui_oleh`) REFERENCES `tb_users` (`id`) ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Data tracer study alumni'
        ");
    }

    public function down()
    {
        $this->forge->dropTable('tb_tracer_alumni', true);
    }
}
