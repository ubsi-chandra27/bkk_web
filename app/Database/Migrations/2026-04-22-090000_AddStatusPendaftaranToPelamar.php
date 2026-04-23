<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusPendaftaranToPelamar extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tb_pelamar', [
            'status_pendaftaran' => [
                'type'       => 'ENUM',
                'constraint' => ['menunggu_aktivasi', 'aktif', 'terdaftar'],
                'default'    => 'menunggu_aktivasi',
                'null'       => false,
                'after'      => 'nomer_nik',
            ],
            'terdaftar_pada' => [
                'type'  => 'DATETIME',
                'null'  => true,
                'after' => 'status_pendaftaran',
            ],
            'diaktivasi_oleh' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'terdaftar_pada',
            ],
            'diaktivasi_pada' => [
                'type'  => 'DATETIME',
                'null'  => true,
                'after' => 'diaktivasi_oleh',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tb_pelamar', [
            'status_pendaftaran',
            'terdaftar_pada',
            'diaktivasi_oleh',
            'diaktivasi_pada',
        ]);
    }
}
