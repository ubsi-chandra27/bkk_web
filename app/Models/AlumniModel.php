<?php

namespace App\Models;

use CodeIgniter\Model;

class AlumniModel extends Model
{
    protected $table      = 'tb_alumni';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_pelamar',
        'id_angkatan',
        'id_jurusan',
        'nis',
        'nisn',
        'no_ijazah',
        'is_verifikasi'
    ];
    protected $useTimestamps = true;

    public function getByPelamar($idPelamar)
    {
        return $this->db->table('tb_alumni')
            ->select('tb_alumni.*, tb_angkatan.tahun, tb_jurusan.kompetensi_keahlian, tb_jurusan.akronim')
            ->join('tb_angkatan', 'tb_angkatan.id = tb_alumni.id_angkatan', 'left')
            ->join('tb_jurusan', 'tb_jurusan.id = tb_alumni.id_jurusan', 'left')
            ->where('tb_alumni.id_pelamar', $idPelamar)
            ->get()->getRowArray();
    }

    /**
     * Get total alumni count
     */
    public function getTotalAlumni(): int
    {
        return $this->countAll();
    }

    /**
     * Get alumni count from last month
     */
    public function getLastMonthAlumniCount(): int
    {
        return $this->where('DATE_FORMAT(created_at, "%Y-%m")', date('Y-m', strtotime('last month')))
                    ->countAllResults();
    }
}
