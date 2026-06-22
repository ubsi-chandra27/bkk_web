<?php

namespace App\Models;

use CodeIgniter\Model;

class LowonganModel extends Model
{
    protected $table            = 'tb_lowongan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_perusahaan',
        'posisi',
        'gaji',
        'deskripsi_pekerjaan',
        'kualifikasi',
        'jenis_pekerjaan',
        'lokasi_kerja',
        'batas_lamaran',
        'status',
        'dibuat_oleh',
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

    public function getLowongan()
    {
        return $this->db->table('tb_lowongan')
            ->select('tb_lowongan.*, tb_perusahaan.nama_perusahaan, tb_perusahaan.logo, users_admin.nama as dibuat_oleh_nama')
            ->join('tb_perusahaan', 'tb_perusahaan.id = tb_lowongan.id_perusahaan', 'left')
            ->join('tb_users as users_admin', 'users_admin.id = tb_lowongan.dibuat_oleh', 'left')
            ->orderBy('tb_lowongan.id', 'DESC')
            ->get()->getResultArray();
    }

    public function getLowonganbyCompanyId($companyId)
    {
        return $this->db->table('tb_lowongan')
            ->select('tb_lowongan.*, tb_perusahaan.nama_perusahaan, tb_perusahaan.logo, users_admin.nama as dibuat_oleh_nama')
            ->join('tb_perusahaan', 'tb_perusahaan.id = tb_lowongan.id_perusahaan', 'left')
            ->join('tb_users as users_admin', 'users_admin.id = tb_lowongan.dibuat_oleh', 'left')
            ->where('tb_lowongan.id_perusahaan', $companyId)
            ->orderBy('tb_lowongan.id', 'DESC')
            ->get()->getResultArray();
    }

    public function getFiltered(array $filters = [], $companyId = null): array
    {
        $builder = $this->db->table('tb_lowongan')
            ->select('tb_lowongan.*, tb_perusahaan.nama_perusahaan, tb_perusahaan.logo, users_admin.nama as dibuat_oleh_nama')
            ->join('tb_perusahaan', 'tb_perusahaan.id = tb_lowongan.id_perusahaan', 'left')
            ->join('tb_users as users_admin', 'users_admin.id = tb_lowongan.dibuat_oleh', 'left');

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
            ->orderBy('tb_lowongan.id', 'DESC')
            ->get()
            ->getResultArray();
    }



    public function getJurusanByLowongan($idLowongan)
    {
        return $this->db->table('tb_lowongan_jurusan')
            ->select('tb_jurusan.id, tb_jurusan.kompetensi_keahlian, tb_jurusan.akronim')
            ->join('tb_jurusan', 'tb_jurusan.id = tb_lowongan_jurusan.id_jurusan')
            ->where('tb_lowongan_jurusan.id_lowongan', $idLowongan)
            ->get()->getResultArray();
    }

    public function getSyaratBerkasByLowongan(int $idLowongan): array
    {
        return $this->db->table('tb_syarat_berkas tsb')
            ->select('tsb.id_jenis_berkas, tjb.slug_berkas as kode, tjb.nama_berkas, tjb.keterangan as deskripsi, tsb.wajib as is_wajib')
            ->join('tb_jenis_berkas tjb', 'tjb.id_jenis_berkas = tsb.id_jenis_berkas')
            ->where('tsb.id_lowongan', $idLowongan)
            ->orderBy('tjb.nama_berkas', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getLowonganAktif(int $limit = 6, array $filters = []): array
    {
        $builder = $this->db->table('tb_lowongan tl')
            ->select('tl.*, tp.nama_perusahaan, tp.logo, tp.kota, tp.alamat')
            ->join('tb_perusahaan tp', 'tp.id = tl.id_perusahaan', 'left')
            ->where('tl.status', 'aktif');

        if (!empty($filters['posisi'])) {
            $builder->like('tl.posisi', $filters['posisi']);
        }

        if (!empty($filters['lokasi'])) {
            $builder->where('tl.lokasi_kerja', $filters['lokasi']);
        }

        if (!empty($filters['jurusan']) && ctype_digit((string) $filters['jurusan'])) {
            $builder->join('tb_lowongan_jurusan tlj_filter', 'tlj_filter.id_lowongan = tl.id')
                ->where('tlj_filter.id_jurusan', (int) $filters['jurusan']);
        }

        if (!empty($filters['gaji'])) {
            $gajiExpression = "CAST(NULLIF(REPLACE(REPLACE(REPLACE(REPLACE(tl.gaji, 'Rp', ''), '.', ''), ',', ''), ' ', ''), '') AS UNSIGNED)";

            if ($filters['gaji'] === 'lt5') {
                $builder->where($gajiExpression . ' < 5000000', null, false);
            } elseif ($filters['gaji'] === '5to10') {
                $builder->where($gajiExpression . ' BETWEEN 5000000 AND 10000000', null, false);
            } elseif ($filters['gaji'] === '10to15') {
                $builder->where($gajiExpression . ' BETWEEN 10000000 AND 15000000', null, false);
            } elseif ($filters['gaji'] === 'gt15') {
                $builder->where($gajiExpression . ' > 15000000', null, false);
            }
        }

        $builder->orderBy('tl.id', 'DESC');

        if ($limit > 0) {
            $builder->limit($limit);
        }

        return $builder->get()->getResultArray();
    }

    public function getJurusanLowonganAktif(): array
    {
        return $this->db->table('tb_lowongan_jurusan tlj')
            ->select('tj.id, tj.kompetensi_keahlian, tj.akronim')
            ->distinct()
            ->join('tb_lowongan tl', 'tl.id = tlj.id_lowongan')
            ->join('tb_jurusan tj', 'tj.id = tlj.id_jurusan')
            ->where('tl.status', 'aktif')
            ->orderBy('tj.kompetensi_keahlian', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getLokasiLowonganAktif(): array
    {
        return $this->db->table('tb_lowongan tl')
            ->select('tl.lokasi_kerja as lokasi')
            ->distinct()
            ->where('tl.status', 'aktif')
            ->where('tl.lokasi_kerja IS NOT NULL', null, false)
            ->where('tl.lokasi_kerja !=', '')
            ->orderBy('tl.lokasi_kerja', 'ASC')
            ->get()
            ->getResultArray();
    }


    /**
     * Detail lowongan + data lengkap perusahaan
     */
    public function getDetailLowongan(int $id): ?array
    {
        $result = $this->db->table('tb_lowongan tl')
            ->select('tl.*, tp.nama_perusahaan, tp.logo, tp.kota,
                      tp.alamat, tp.no_telepon, tp.email as email_perusahaan,
                      tp.website, tp.bidang_usaha')
            ->join('tb_perusahaan tp', 'tp.id = tl.id_perusahaan', 'left')
            ->where('tl.id', $id)
            ->get()->getRowArray();

        return $result ?: null;
    }

    /**
     * Hitung total lowongan aktif (untuk statistik hero)
     */
    public function countAktif(): int
    {
        return $this->where('status', 'aktif')->countAllResults();
    }

    /**
     * Get active job count for today (newly created)
     */
    public function getTodayActiveJobCount(): int
    {
        return $this->where('status', 'aktif')
            ->where('DATE(created_at)', date('Y-m-d'))
            ->countAllResults();
    }
}
