<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RefactorBerkasStructure extends Migration
{
    public function up()
    {
        if (!$this->db->tableExists('tb_jenis_berkas')) {
            $this->forge->addField([
                'id_jenis_berkas' => [
                    'type'           => 'INT',
                    'constraint'     => 10,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'nama_berkas' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ],
                'slug_berkas' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                ],
                'berlaku_untuk' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => true,
                ],
                'keterangan' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'status_aktif' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'default'    => 1,
                ],
                'dibuat_pada' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'diperbarui_pada' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
            $this->forge->addKey('id_jenis_berkas', true);
            $this->forge->addUniqueKey('slug_berkas');
            $this->forge->createTable('tb_jenis_berkas', true);
        }

        if (!$this->db->tableExists('tb_syarat_berkas')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 10,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'id_lowongan' => [
                    'type'       => 'INT',
                    'constraint' => 10,
                    'unsigned'   => true,
                ],
                'id_jenis_berkas' => [
                    'type'       => 'INT',
                    'constraint' => 10,
                    'unsigned'   => true,
                ],
                'wajib' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'default'    => 1,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addKey(['id_lowongan', 'id_jenis_berkas']);
            $this->forge->createTable('tb_syarat_berkas', true);
        }

        $now = date('Y-m-d H:i:s');
        $jenisBerkas = [
            ['slug_berkas' => 'cv', 'nama_berkas' => 'CV / Resume', 'keterangan' => 'Curriculum vitae atau resume pelamar'],
            ['slug_berkas' => 'surat_lamaran', 'nama_berkas' => 'Surat Lamaran', 'keterangan' => 'Surat lamaran kerja'],
            ['slug_berkas' => 'ijazah', 'nama_berkas' => 'Ijazah', 'keterangan' => 'Ijazah terakhir'],
            ['slug_berkas' => 'ktp', 'nama_berkas' => 'KTP', 'keterangan' => 'Kartu Tanda Penduduk'],
            ['slug_berkas' => 'skck', 'nama_berkas' => 'SKCK', 'keterangan' => 'Surat Keterangan Catatan Kepolisian'],
        ];

        $db = $this->db;
        $jenisBerkasFields = array_map(static fn($field) => $field->name, $db->getFieldData('tb_jenis_berkas'));
        foreach ($jenisBerkas as $item) {
            $slugField = in_array('slug_berkas', $jenisBerkasFields, true) ? 'slug_berkas' : 'kode';
            $exists = $db->table('tb_jenis_berkas')->where($slugField, $item['slug_berkas'])->get()->getRowArray();
            if (!$exists) {
                $insertData = [
                    'nama_berkas' => $item['nama_berkas'],
                ];

                if (in_array('slug_berkas', $jenisBerkasFields, true)) {
                    $insertData['slug_berkas'] = $item['slug_berkas'];
                } else {
                    $insertData['kode'] = $item['slug_berkas'];
                }

                if (in_array('keterangan', $jenisBerkasFields, true)) {
                    $insertData['keterangan'] = $item['keterangan'];
                } elseif (in_array('deskripsi', $jenisBerkasFields, true)) {
                    $insertData['deskripsi'] = $item['keterangan'];
                }

                if (in_array('status_aktif', $jenisBerkasFields, true)) {
                    $insertData['status_aktif'] = 1;
                } elseif (in_array('is_active', $jenisBerkasFields, true)) {
                    $insertData['is_active'] = 1;
                }

                if (in_array('dibuat_pada', $jenisBerkasFields, true)) {
                    $insertData['dibuat_pada'] = $now;
                } elseif (in_array('created_at', $jenisBerkasFields, true)) {
                    $insertData['created_at'] = $now;
                }

                if (in_array('diperbarui_pada', $jenisBerkasFields, true)) {
                    $insertData['diperbarui_pada'] = $now;
                } elseif (in_array('updated_at', $jenisBerkasFields, true)) {
                    $insertData['updated_at'] = $now;
                }

                $db->table('tb_jenis_berkas')->insert($insertData);
            }
        }

        $fields = array_map(static fn($field) => $field->name, $db->getFieldData('tb_berkas'));

        if (!in_array('id_jenis_berkas', $fields, true)) {
            $this->forge->addColumn('tb_berkas', [
                'id_jenis_berkas' => [
                    'type'       => 'INT',
                    'constraint' => 10,
                    'unsigned'   => true,
                    'null'       => true,
                    'after'      => 'id_pelamar',
                ],
            ]);
        }

        if (in_array('jenis_berkas', $fields, true)) {
            $rows = $db->table('tb_berkas')->get()->getResultArray();
            $jenisMap = [];
            foreach ($db->table('tb_jenis_berkas')->get()->getResultArray() as $jenis) {
                $slug = $jenis['slug_berkas'] ?? $jenis['kode'] ?? null;
                $id = $jenis['id_jenis_berkas'] ?? $jenis['id'] ?? null;
                if ($slug !== null && $id !== null) {
                    $jenisMap[$slug] = $id;
                }
            }

            foreach ($rows as $row) {
                $kode = strtolower((string) ($row['jenis_berkas'] ?? ''));
                if (isset($jenisMap[$kode])) {
                    $db->table('tb_berkas')
                        ->where('id', $row['id'])
                        ->update(['id_jenis_berkas' => $jenisMap[$kode]]);
                }
            }

            $dropColumns = ['jenis_berkas'];
            if (in_array('is_wajib', $fields, true)) {
                $dropColumns[] = 'is_wajib';
            }
            $this->forge->dropColumn('tb_berkas', $dropColumns);
        }

        $this->forge->modifyColumn('tb_berkas', [
            'id_jenis_berkas' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => false,
                'default'    => 0,
            ],
        ]);
    }

    public function down()
    {
        $fields = array_map(static fn($field) => $field->name, $this->db->getFieldData('tb_berkas'));

        if (!in_array('jenis_berkas', $fields, true)) {
            $this->forge->addColumn('tb_berkas', [
                'jenis_berkas' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => true,
                    'after'      => 'id_pelamar',
                ],
                'is_wajib' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'default'    => 0,
                    'after'      => 'jenis_berkas',
                ],
            ]);
        }

        if (in_array('id_jenis_berkas', $fields, true)) {
            $jenisMap = [];
            foreach ($this->db->table('tb_jenis_berkas')->get()->getResultArray() as $jenis) {
                $id = $jenis['id_jenis_berkas'] ?? $jenis['id'] ?? null;
                $slug = $jenis['slug_berkas'] ?? $jenis['kode'] ?? null;
                if ($id !== null) {
                    $jenisMap[$id] = $slug;
                }
            }

            $rows = $this->db->table('tb_berkas')->get()->getResultArray();
            foreach ($rows as $row) {
                $this->db->table('tb_berkas')
                    ->where('id', $row['id'])
                    ->update([
                        'jenis_berkas' => $jenisMap[$row['id_jenis_berkas']] ?? null,
                        'is_wajib'     => 0,
                    ]);
            }

            $this->forge->dropColumn('tb_berkas', 'id_jenis_berkas');
        }

        if ($this->db->tableExists('tb_syarat_berkas')) {
            $this->forge->dropTable('tb_syarat_berkas', true);
        }
        if ($this->db->tableExists('tb_jenis_berkas')) {
            $this->forge->dropTable('tb_jenis_berkas', true);
        }
    }
}
