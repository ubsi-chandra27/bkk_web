<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTracerAktivitasNullable extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('tb_tracer_alumni', [
            'id_aktivitas' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('tb_tracer_alumni', [
            'id_aktivitas' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);
    }
}
