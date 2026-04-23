<?php

namespace App\Models;

use CodeIgniter\Model;

class BerkasLamaranModel extends Model
{
    protected $table = 'tb_berkas_lamaran';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;

    protected $allowedFields = [
        'id_lamaran',
        'id_jenis_berkas',
        'file_path',
        'file_name',
        'file_size',
        'uploaded_at',
    ];

    public function getByLamaran(int $idLamaran): array
    {
        return $this->db->table('tb_berkas_lamaran tbl')
            ->select('tbl.*, tjb.slug_berkas, tjb.nama_berkas, tjb.keterangan')
            ->join('tb_jenis_berkas tjb', 'tjb.id_jenis_berkas = tbl.id_jenis_berkas', 'left')
            ->where('tbl.id_lamaran', $idLamaran)
            ->where('tbl.deleted_at', null)
            ->orderBy('tbl.id', 'ASC')
            ->get()
            ->getResultArray();
    }
}
