<?php

namespace App\Models;

use CodeIgniter\Model;

class SyaratBerkasModel extends Model
{
    protected $table = 'tb_syarat_berkas';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'id_lowongan',
        'id_jenis_berkas',
        'wajib',
    ];

    public function getByLowongan(int $idLowongan): array
    {
        return $this->db->table('tb_syarat_berkas tsb')
            ->select('tsb.id, tsb.id_lowongan, tsb.id_jenis_berkas, tsb.wajib as is_wajib, tjb.slug_berkas as kode, tjb.nama_berkas, tjb.keterangan as deskripsi, tjb.status_aktif')
            ->join('tb_jenis_berkas tjb', 'tjb.id_jenis_berkas = tsb.id_jenis_berkas')
            ->where('tsb.id_lowongan', $idLowongan)
            ->orderBy('tjb.nama_berkas', 'ASC')
            ->get()
            ->getResultArray();
    }
}
