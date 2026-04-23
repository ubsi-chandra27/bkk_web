<?php

namespace App\Models;

use CodeIgniter\Model;

class MouModel extends Model
{
    protected $table            = 'tb_mou';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_perusahaan',
        'id_kerjasama',
        'nomor_mou',
        'tanggal_mou',
        'tanggal_berlaku',
        'tanggal_berakhir',
        'file_mou',
        'status',
        'created_by',
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

    public function getMou()
    {
        return $this->db->table('tb_mou')
            ->select('tb_mou.*, tb_perusahaan.nama_perusahaan, tb_kerjasama.nama_kerjasama as nama_kerjasama')
            ->join('tb_perusahaan', 'tb_perusahaan.id = tb_mou.id_perusahaan', 'left')
            ->join('tb_kerjasama', 'tb_kerjasama.id = tb_mou.id_kerjasama', 'left')
            ->orderBy('tb_mou.id', 'DESC')
            ->get()->getResultArray();
    }
}
