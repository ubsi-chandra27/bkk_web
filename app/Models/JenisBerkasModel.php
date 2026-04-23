<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisBerkasModel extends Model
{
    protected $table = 'tb_jenis_berkas';
    protected $primaryKey = 'id_jenis_berkas';
    protected $returnType = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'nama_berkas',
        'slug_berkas',
        'berlaku_untuk',
        'keterangan',
        'status_aktif',
        'dibuat_pada',
        'diperbarui_pada',
    ];

    public function getAktif(): array
    {
        return $this->db->table($this->table)
            ->select('id_jenis_berkas as id, nama_berkas, slug_berkas as kode, keterangan as deskripsi, status_aktif')
            ->where('status_aktif', 1)
            ->orderBy('nama_berkas', 'ASC')
            ->get()
            ->getResultArray();
    }
}
