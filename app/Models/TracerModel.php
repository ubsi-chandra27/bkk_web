<?php

namespace App\Models;

use CodeIgniter\Model;

class TracerModel extends Model
{
    protected $table      = 'tb_tracer_alumni';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_alumni',
        'id_aktivitas',
        'status',
        'diverifikasi_oleh',
        'diverifikasi_at',
        'disetujui_oleh',
        'disetujui_at',
        'posisi_kerja',
        'nama_dudi',
        'bidang_dudi',
        'alamat_dudi',
        'tahun_mulai_kerja',
        'is_relevan_jurusan',
        'penghasilan_range',
        'universitas',
        'program_studi',
        'status_kuliah',
        'nama_usaha',
        'bidang_usaha',
        'modal_awal',
        'penghasilan_usaha',
        'rencana_universitas',
        'rencana_prodi',
    ];
    protected $useTimestamps = true;

    public function getByAlumni($idAlumni)
    {
        return $this->db->table('tb_tracer_alumni')
            ->select('tb_tracer_alumni.*, tb_aktivitas.nama_aktivitas')
            ->join('tb_aktivitas', 'tb_aktivitas.id = tb_tracer_alumni.id_aktivitas', 'left')
            ->where('tb_tracer_alumni.id_alumni', $idAlumni)
            ->get()->getRowArray();
    }

    public function getFiltered(array $filters = []): array
    {
        $builder = $this->db->table('tb_tracer_alumni')
            ->select('
                tb_tracer_alumni.*,
                tb_alumni.id_pelamar,
                tb_users.id as id_user,
                tb_users.nama,
                tb_jurusan.kompetensi_keahlian,
                tb_jurusan.akronim,
                tb_angkatan.tahun,
                tb_aktivitas.nama_aktivitas
            ')
            ->join('tb_alumni', 'tb_alumni.id = tb_tracer_alumni.id_alumni', 'left')
            ->join('tb_pelamar', 'tb_pelamar.id = tb_alumni.id_pelamar', 'left')
            ->join('tb_users', 'tb_users.id = tb_pelamar.id_user', 'left')
            ->join('tb_jurusan', 'tb_jurusan.id = tb_alumni.id_jurusan', 'left')
            ->join('tb_angkatan', 'tb_angkatan.id = tb_alumni.id_angkatan', 'left')
            ->join('tb_aktivitas', 'tb_aktivitas.id = tb_tracer_alumni.id_aktivitas', 'left');

        if (! empty($filters['jurusan'])) {
            $builder->where('tb_alumni.id_jurusan', $filters['jurusan']);
        }

        if (! empty($filters['angkatan'])) {
            $builder->where('tb_alumni.id_angkatan', $filters['angkatan']);
        }

        if (! empty($filters['aktivitas'])) {
            $builder->where('tb_tracer_alumni.id_aktivitas', $filters['aktivitas']);
        }

        return $builder
            ->orderBy('tb_tracer_alumni.id', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getFilterJurusanOptions(): array
    {
        return $this->db->table('tb_tracer_alumni')
            ->select('tb_jurusan.id, tb_jurusan.kompetensi_keahlian, tb_jurusan.akronim')
            ->join('tb_alumni', 'tb_alumni.id = tb_tracer_alumni.id_alumni', 'left')
            ->join('tb_jurusan', 'tb_jurusan.id = tb_alumni.id_jurusan', 'left')
            ->where('tb_jurusan.id IS NOT NULL')
            ->groupBy(['tb_jurusan.id', 'tb_jurusan.kompetensi_keahlian', 'tb_jurusan.akronim'])
            ->orderBy('tb_jurusan.kompetensi_keahlian', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getFilterAngkatanOptions(): array
    {
        return $this->db->table('tb_tracer_alumni')
            ->select('tb_angkatan.id, tb_angkatan.tahun')
            ->join('tb_alumni', 'tb_alumni.id = tb_tracer_alumni.id_alumni', 'left')
            ->join('tb_angkatan', 'tb_angkatan.id = tb_alumni.id_angkatan', 'left')
            ->where('tb_angkatan.id IS NOT NULL')
            ->groupBy(['tb_angkatan.id', 'tb_angkatan.tahun'])
            ->orderBy('tb_angkatan.tahun', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getFilterAktivitasOptions(): array
    {
        return $this->db->table('tb_tracer_alumni')
            ->select('tb_aktivitas.id, tb_aktivitas.nama_aktivitas')
            ->join('tb_aktivitas', 'tb_aktivitas.id = tb_tracer_alumni.id_aktivitas', 'left')
            ->where('tb_aktivitas.id IS NOT NULL')
            ->groupBy(['tb_aktivitas.id', 'tb_aktivitas.nama_aktivitas'])
            ->orderBy('tb_aktivitas.nama_aktivitas', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Get tracer count per month for last 6 months (for line chart)
     */
    public function getTracerChartData(): array
    {
        $db = \Config\Database::connect();
        $data = [];
        $labels = [];

        // Get last 6 months including current
        for ($i = 5; $i >= 0; $i--) {
            $monthYear = date('Y-m', strtotime("-$i months"));
            $labels[] = date('M Y', strtotime("-$i months"));

            $count = $db->table('tb_tracer_alumni')
                ->where('DATE_FORMAT(created_at, "%Y-%m")', $monthYear)
                ->countAllResults();

            $data[] = (int) $count;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * Get alumni status distribution (for pie chart)
     * Based on id_aktivitas from tb_aktivitas
     */
    public function getStatusAlumniDistribution(): array
    {
        $db = \Config\Database::connect();

        $result = $db->table('tb_tracer_alumni ta')
            ->select('tb_aktivitas.nama_aktivitas as label, COUNT(ta.id) as value')
            ->join('tb_aktivitas', 'tb_aktivitas.id = ta.id_aktivitas', 'left')
            ->where('ta.status', 'disetujui') // Only approved tracer data
            ->groupBy('ta.id_aktivitas')
            ->get()->getResultArray();

        $distribution = [];
        foreach ($result as $row) {
            $distribution[] = [
                'label' => $row['label'],
                'value' => (int) $row['value']
            ];
        }

        return $distribution;
    }

    /**
     * Get latest tracer data with alumni details (limit 5)
     */
    public function getTracerTerbaru(int $limit = 5): array
    {
        $db = \Config\Database::connect();

        return $db->table('tb_tracer_alumni ta')
            ->select('ta.*, 
                      tb_users.nama as nama_alumni,
                      tb_angkatan.tahun as angkatan,
                      tb_jurusan.kompetensi_keahlian as jurusan,
                      tb_aktivitas.nama_aktivitas as status_aktivitas,
                      ta.updated_at')
            ->join('tb_alumni', 'tb_alumni.id = ta.id_alumni', 'left')
            ->join('tb_pelamar', 'tb_pelamar.id = tb_alumni.id_pelamar', 'left')
            ->join('tb_users', 'tb_users.id = tb_pelamar.id_user', 'left')
            ->join('tb_angkatan', 'tb_angkatan.id = tb_alumni.id_angkatan', 'left')
            ->join('tb_jurusan', 'tb_jurusan.id = tb_alumni.id_jurusan', 'left')
            ->join('tb_aktivitas', 'tb_aktivitas.id = ta.id_aktivitas', 'left')
            ->orderBy('ta.updated_at', 'DESC')
            ->limit($limit)
            ->get()->getResultArray();
    }

    /**
     * Get total approved alumni count (for stats)
     */
    public function getTotalApprovedAlumni(): int
    {
        return $this->db->table('tb_tracer_alumni')
            ->where('status', 'disetujui')
            ->countAllResults();
    }

    /**
     * Get alumni count from tb_alumni table
     */
    public function getTotalAlumniCount(): int
    {
        $alumniModel = new \App\Models\AlumniModel();
        return $alumniModel->countAll();
    }

    public function getExportData(array $filters = []): array
    {
        $builder = $this->db->table('tb_tracer_alumni')
            ->select([
                'tb_users.nama AS nama',
                'tb_alumni.nis',
                'tb_alumni.nisn',
                'tb_alumni.no_ijazah',
                'tb_jurusan.kompetensi_keahlian AS nama_jurusan',
                'tb_angkatan.tahun AS nama_angkatan',
                'tb_aktivitas.nama_aktivitas',
                'tb_tracer_alumni.posisi_kerja',
                'tb_tracer_alumni.nama_dudi',
                'tb_tracer_alumni.bidang_dudi',
                'tb_tracer_alumni.alamat_dudi',
                'tb_tracer_alumni.tahun_mulai_kerja',
                'tb_tracer_alumni.is_relevan_jurusan',
                'tb_tracer_alumni.penghasilan_range',
                'tb_tracer_alumni.universitas',
                'tb_tracer_alumni.program_studi',
                'tb_tracer_alumni.status_kuliah',
                'tb_tracer_alumni.nama_usaha',
                'tb_tracer_alumni.bidang_usaha',
                'tb_tracer_alumni.modal_awal',
                'tb_tracer_alumni.penghasilan_usaha',
                'tb_tracer_alumni.rencana_universitas',
                'tb_tracer_alumni.rencana_prodi',
            ])
            ->join('tb_alumni', 'tb_alumni.id = tb_tracer_alumni.id_alumni')
            ->join('tb_pelamar', 'tb_pelamar.id = tb_alumni.id_pelamar', 'left')
            ->join('tb_users', 'tb_users.id = tb_pelamar.id_user', 'left')
            ->join('tb_jurusan', 'tb_jurusan.id = tb_alumni.id_jurusan')
            ->join('tb_angkatan', 'tb_angkatan.id = tb_alumni.id_angkatan')
            ->join('tb_aktivitas', 'tb_aktivitas.id = tb_tracer_alumni.id_aktivitas')
            ->where('tb_tracer_alumni.status', 'disetujui');

        if (! empty($filters['id_jurusan'])) {
            $builder->where('tb_alumni.id_jurusan', $filters['id_jurusan']);
        }

        if (! empty($filters['id_angkatan'])) {
            $builder->where('tb_alumni.id_angkatan', $filters['id_angkatan']);
        }

        if (! empty($filters['id_aktivitas'])) {
            $builder->where('tb_tracer_alumni.id_aktivitas', $filters['id_aktivitas']);
        }

        return $builder
            ->orderBy('tb_aktivitas.nama_aktivitas', 'ASC')
            ->orderBy('tb_angkatan.tahun', 'ASC')
            ->orderBy('tb_jurusan.kompetensi_keahlian', 'ASC')
            ->get()
            ->getResultArray();
    }
}
