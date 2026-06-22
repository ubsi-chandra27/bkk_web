<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotifications extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `notifications` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `user_id` int(11) UNSIGNED NOT NULL COMMENT 'Penerima notifikasi - FK ke tb_users.id',
                `sender_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'Pengirim notifikasi - FK ke tb_users.id, null jika dari sistem',
                `type` enum('new_application','status_changed','new_user','tracer_study_submitted') NOT NULL COMMENT 'Kategori notifikasi',
                `title` varchar(255) NOT NULL,
                `message` text NOT NULL,
                `url` varchar(255) DEFAULT NULL,
                `is_read` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = belum dibaca, 1 = sudah dibaca',
                `created_at` datetime DEFAULT NULL,
                `updated_at` datetime DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `notifications_sender_id_foreign` (`sender_id`),
                KEY `user_id` (`user_id`),
                KEY `is_read` (`is_read`),
                CONSTRAINT `notifications_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `tb_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ");
    }

    public function down()
    {
        $this->forge->dropTable('notifications', true);
    }
}
