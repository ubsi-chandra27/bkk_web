<?php

namespace App\Models;

use CodeIgniter\Model;

class LamaranStatusModel extends Model
{
    protected $table            = 'tb_lamaran_status';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_lamaran',
        'status_lama',
        'status_baru',
        'catatan',
        'diubah_oleh',
        'created_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getAllRiwayat($companyId = null)
    {
        $builder = $this->select('
            tb_lamaran_status.*,
            u.nama as nama_user,
            p_user.nama as nama_pelamar,
            lw.posisi,
            pr.nama_perusahaan
        ')
            ->join('tb_users u', 'u.id = tb_lamaran_status.diubah_oleh', 'left')

            ->join('tb_lamaran l', 'l.id = tb_lamaran_status.id_lamaran')
            ->join('tb_pelamar p', 'p.id = l.id_pelamar')
            ->join('tb_users p_user', 'p_user.id = p.id_user')

            ->join('tb_lowongan lw', 'lw.id = l.id_lowongan')
            ->join('tb_perusahaan pr', 'pr.id = lw.id_perusahaan')

            ->orderBy('tb_lamaran_status.created_at', 'DESC');

        if ($companyId !== null) {
            $builder->where('lw.id_perusahaan', $companyId);
        }

        return $builder->findAll();
    }
}
