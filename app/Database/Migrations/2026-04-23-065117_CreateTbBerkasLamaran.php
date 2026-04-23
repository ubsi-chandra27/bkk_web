<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbBerkasLamaran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_lamaran' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => false,
            ],
            'id_jenis_berkas' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => false,
            ],
            'file_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => false,
            ],
            'file_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'file_size' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'Ukuran file dalam bytes',
            ],
            'uploaded_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_lamaran', 'tb_lamaran', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_jenis_berkas', 'tb_jenis_berkas', 'id_jenis_berkas', 'RESTRICT', 'RESTRICT');

        $this->forge->createTable('tb_berkas_lamaran');
    }

    public function down()
    {
        $this->forge->dropTable('tb_berkas_lamaran', true);
    }
}
