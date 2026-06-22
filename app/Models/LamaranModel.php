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
        'dibuat_oleh'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

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

    public function getLamaranWithRelasi($companyId = null)
    {
        $builder = $this->db->table('tb_lamaran')
            ->select('tb_lamaran.*, 
                  tb_pelamar.id_user,
                  tb_users.nama as nama_pelamar, 
                  tb_perusahaan.nama_perusahaan,
                  tb_perusahaan.logo as logo_perusahaan,
                  tb_lowongan.posisi, 
                  tb_lowongan.id_perusahaan,
                  users_admin.nama as dibuat_oleh_nama')
            ->join('tb_pelamar', 'tb_pelamar.id = tb_lamaran.id_pelamar')
            ->join('tb_users', 'tb_users.id = tb_pelamar.id_user')
            ->join('tb_lowongan', 'tb_lowongan.id = tb_lamaran.id_lowongan')
            ->join('tb_perusahaan', 'tb_perusahaan.id = tb_lowongan.id_perusahaan')
            ->join('tb_users as users_admin', 'users_admin.id = tb_lamaran.dibuat_oleh', 'left')
            ->orderBy('tb_lamaran.created_at', 'DESC');

        if ($companyId !== null) {
            $builder->where('tb_lowongan.id_perusahaan', $companyId);
        }

        return $builder->get()->getResultArray();
    }

    public function getFiltered(array $filters = [], $companyId = null): array
    {
        $builder = $this->db->table('tb_lamaran')
            ->select('tb_lamaran.*, 
                  tb_pelamar.id_user,
                  tb_users.nama as nama_pelamar, 
                  tb_perusahaan.nama_perusahaan,
                  tb_perusahaan.logo as logo_perusahaan,
                  tb_lowongan.posisi, 
                  tb_lowongan.id_perusahaan,
                  users_admin.nama as dibuat_oleh_nama')
            ->join('tb_pelamar', 'tb_pelamar.id = tb_lamaran.id_pelamar')
            ->join('tb_users', 'tb_users.id = tb_pelamar.id_user')
            ->join('tb_lowongan', 'tb_lowongan.id = tb_lamaran.id_lowongan')
            ->join('tb_perusahaan', 'tb_perusahaan.id = tb_lowongan.id_perusahaan')
            ->join('tb_users as users_admin', 'users_admin.id = tb_lamaran.dibuat_oleh', 'left');

        if ($companyId !== null) {
            $builder->where('tb_lowongan.id_perusahaan', $companyId);
        }

        if (! empty($filters['perusahaan'])) {
            $builder->like('tb_perusahaan.nama_perusahaan', $filters['perusahaan']);
        }

        if (! empty($filters['posisi'])) {
            $builder->like('tb_lowongan.posisi', $filters['posisi']);
        }

        return $builder
            ->orderBy('tb_lamaran.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }
}
