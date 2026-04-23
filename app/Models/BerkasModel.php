<?php

namespace App\Models;

use CodeIgniter\Model;

class BerkasModel extends Model
{
    protected $table      = 'tb_berkas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_pelamar',
        'id_jenis_berkas',
        'nama_file',
        'path_file',
        'status'
    ];
    protected $useTimestamps = true;

    public function getByPelamar($idPelamar)
    {
        return $this->db->table('tb_berkas tb')
            ->select('tb.*, tjb.slug_berkas as jenis_berkas, tjb.nama_berkas, tjb.keterangan as deskripsi')
            ->join('tb_jenis_berkas tjb', 'tjb.id_jenis_berkas = tb.id_jenis_berkas', 'left')
            ->where('tb.id_pelamar', $idPelamar)
            ->orderBy('tjb.nama_berkas', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getByPelamarAndJenis(int $idPelamar, int $idJenisBerkas): ?array
    {
        return $this->where('id_pelamar', $idPelamar)
            ->where('id_jenis_berkas', $idJenisBerkas)
            ->first();
    }
}
