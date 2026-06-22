<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNewNotificationTypes extends Migration
{
    public function up()
    {
        $this->db->query("
            ALTER TABLE `notifications`
            MODIFY `type` ENUM('new_application', 'status_changed', 'new_user', 'tracer_study_submitted') NOT NULL COMMENT 'Kategori notifikasi'
        ");
    }

    public function down()
    {
        $this->db->query("
            ALTER TABLE `notifications`
            MODIFY `type` ENUM('new_application', 'status_changed') NOT NULL COMMENT 'Kategori notifikasi'
        ");
    }
}
