<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPasswordResetToTbUsers extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('reset_token', 'tb_users')) {
            $this->forge->addColumn('tb_users', [
                'reset_token' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 64,
                    'null'       => true,
                    'after'      => 'remember_token',
                ],
            ]);
        }

        if (!$this->db->fieldExists('reset_expires', 'tb_users')) {
            $this->forge->addColumn('tb_users', [
                'reset_expires' => [
                    'type'  => 'DATETIME',
                    'null'  => true,
                    'after' => 'reset_token',
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('reset_expires', 'tb_users')) {
            $this->forge->dropColumn('tb_users', 'reset_expires');
        }

        if ($this->db->fieldExists('reset_token', 'tb_users')) {
            $this->forge->dropColumn('tb_users', 'reset_token');
        }
    }
}
