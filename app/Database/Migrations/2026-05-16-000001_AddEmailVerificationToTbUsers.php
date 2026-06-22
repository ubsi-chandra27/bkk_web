<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmailVerificationToTbUsers extends Migration
{
    public function up()
    {
        $isVerifiedWasAdded = false;
        $afterResetColumn = $this->db->fieldExists('reset_expires', 'tb_users') ? 'reset_expires' : 'remember_token';

        if (!$this->db->fieldExists('email_token', 'tb_users')) {
            $this->forge->addColumn('tb_users', [
                'email_token' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 64,
                    'null'       => true,
                    'after'      => $afterResetColumn,
                ],
            ]);
        }

        if (!$this->db->fieldExists('email_verified_at', 'tb_users')) {
            $this->forge->addColumn('tb_users', [
                'email_verified_at' => [
                    'type'  => 'DATETIME',
                    'null'  => true,
                    'after' => 'email_token',
                ],
            ]);
        }

        if (!$this->db->fieldExists('is_verified', 'tb_users')) {
            $this->forge->addColumn('tb_users', [
                'is_verified' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'default'    => 0,
                    'after'      => 'email_verified_at',
                ],
            ]);

            $isVerifiedWasAdded = true;
        }

        if ($isVerifiedWasAdded) {
            $this->db->table('tb_users')->update([
                'is_verified'       => 1,
                'email_verified_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('is_verified', 'tb_users')) {
            $this->forge->dropColumn('tb_users', 'is_verified');
        }

        if ($this->db->fieldExists('email_verified_at', 'tb_users')) {
            $this->forge->dropColumn('tb_users', 'email_verified_at');
        }

        if ($this->db->fieldExists('email_token', 'tb_users')) {
            $this->forge->dropColumn('tb_users', 'email_token');
        }
    }
}
