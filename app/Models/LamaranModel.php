<?php

namespace App\Models;

use CodeIgniter\Model;

class LamaranModel extends Model
{
    protected $table      = 'tb_lamaran';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_pelamar',
        'id_lowongan',
        'tanggal_melamar',
        'tanggal_wawancara',
        'status',
        'catatan',
        'dibuat_oleh',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;

    public function getByPelamar($idPelamar)
    {
        return $this->db->table('tb_lamaran')
            ->select('tb_lamaran.*, tb_lowongan.posisi, tb_lowongan.jenis_pekerjaan,
                      tb_lowongan.lokasi_kerja, tb_perusahaan.nama_perusahaan, tb_perusahaan.logo')
            ->join('tb_lowongan', 'tb_lowongan.id = tb_lamaran.id_lowongan', 'left')
            ->join('tb_perusahaan', 'tb_perusahaan.id = tb_lowongan.id_perusahaan', 'left')
            ->where('tb_lamaran.id_pelamar', $idPelamar)
            ->orderBy('tb_lamaran.id', 'DESC')
            ->get()->getResultArray();
    }
}
