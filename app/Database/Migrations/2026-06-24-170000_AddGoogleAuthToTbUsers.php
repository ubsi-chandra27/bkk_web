<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGoogleAuthToTbUsers extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('auth_provider', 'tb_users')) {
            $this->forge->addColumn('tb_users', [
                'auth_provider' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 30,
                    'default'    => 'local',
                    'after'      => 'password',
                ],
            ]);
        }

        if (! $this->db->fieldExists('google_sub', 'tb_users')) {
            $this->forge->addColumn('tb_users', [
                'google_sub' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'auth_provider',
                ],
            ]);
        }

        if (! $this->db->fieldExists('google_picture', 'tb_users')) {
            $this->forge->addColumn('tb_users', [
                'google_picture' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'google_sub',
                ],
            ]);
        }

        if (! $this->hasIndex('google_sub_unique')) {
            $this->db->query('ALTER TABLE `tb_users` ADD UNIQUE KEY `google_sub_unique` (`google_sub`)');
        }
    }

    public function down()
    {
        if ($this->hasIndex('google_sub_unique')) {
            $this->db->query('ALTER TABLE `tb_users` DROP INDEX `google_sub_unique`');
        }

        foreach (['google_picture', 'google_sub', 'auth_provider'] as $field) {
            if ($this->db->fieldExists($field, 'tb_users')) {
                $this->forge->dropColumn('tb_users', $field);
            }
        }
    }

    private function hasIndex(string $indexName): bool
    {
        $row = $this->db->query(
            'SHOW INDEX FROM `tb_users` WHERE Key_name = ?',
            [$indexName]
        )->getRowArray();

        return $row !== null;
    }
}
