<?php

namespace App\Models;

use CodeIgniter\Model;

class PerusahaanModel extends Model
{
    protected $table = 'tb_perusahaan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_user',
        'nama_perusahaan',
        'bidang_usaha',
        'alamat',
        'kota',
        'no_telepon',
        'email',
        'website',
        'logo',
        'is_active',

    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getPerusahaanAktif(): array
    {
        return $this->db->table('tb_perusahaan tp')
            ->select('tp.*, COUNT(tl.id) as total_lowongan')
            ->join('tb_lowongan tl', "tl.id_perusahaan = tp.id AND tl.status = 'aktif'", 'left')
            ->where('tp.is_active', 1)
            ->groupBy('tp.id')
            ->orderBy('tp.nama_perusahaan', 'ASC')
            ->get()->getResultArray();
    }


    /**
     * Get active companies with details for dashboard (limit)
     */
    public function getPerusahaanAktifDashboard(int $limit = 5): array
    {
        return $this->db->table('tb_perusahaan tp')
            ->select('tp.id, tp.nama_perusahaan, tp.logo, COUNT(tl.id) as jumlah_lowongan')
            ->join('tb_lowongan tl', "tl.id_perusahaan = tp.id AND tl.status = 'aktif'", 'left')
            ->where('tp.is_active', 1)
            ->groupBy('tp.id')
            ->orderBy('tp.created_at', 'DESC')
            ->limit($limit)
            ->get()->getResultArray();
    }


    /**
     * Hitung total perusahaan aktif (untuk statistik hero)
     */
    public function countAktif(): int
    {
        return $this->where('is_active', 1)->countAllResults();
    }

    /**
     * Get new companies count for today
     */
    public function getTodayNewCompanyCount(): int
    {
        return $this->where('DATE(created_at)', date('Y-m-d'))
                    ->countAllResults();
    }

    /**
     * Get new companies count from last month
     */
    public function getLastMonthNewCompanyCount(): int
    {
        return $this->where('DATE_FORMAT(created_at, "%Y-%m")', date('Y-m', strtotime('last month')))
                    ->countAllResults();
    }
}
