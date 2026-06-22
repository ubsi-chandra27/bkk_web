<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\TracerModel;
use App\Models\PerusahaanModel;
use App\Models\LowonganModel;
use App\Models\PelamarModel;
use App\Models\AlumniModel;

class DashboardController extends BaseController
{
    /**
     * Get total alumni count
     */
    public function getTotalAlumni(): int
    {
        $alumniModel = new AlumniModel();
        return $alumniModel->getTotalAlumni();
    }

    /**
     * Get total perusahaan (active) count
     */
    public function getTotalPerusahaan(): int
    {
        $perusahaanModel = new PerusahaanModel();
        return $perusahaanModel->countAktif();
    }

    /**
     * Get total lowongan (active) count
     */
    public function getTotalLowongan(): int
    {
        $lowonganModel = new LowonganModel();
        return $lowonganModel->countAktif();
    }

    /**
     * Get total pelamar count
     */
    public function getTotalPelamar(): int
    {
        $pelamarModel = new PelamarModel();
        return $pelamarModel->getTotalPelamar();
    }

    /**
     * Get tracer chart data (6 months)
     */
    public function getTracerChart(): array
    {
        $tracerModel = new TracerModel();
        return $tracerModel->getTracerChartData();
    }

    /**
     * Get alumni status distribution for pie chart
     */
    public function getStatusAlumni(): array
    {
        $tracerModel = new TracerModel();
        return $tracerModel->getStatusAlumniDistribution();
    }

    /**
     * Get active companies for dashboard (limit 5)
     */
    public function getPerusahaanAktif(): array
    {
        $perusahaanModel = new PerusahaanModel();
        return $perusahaanModel->getPerusahaanAktifDashboard(5);
    }

    /**
     * Get latest tracer data (5 records)
     */
    public function getTracerTerbaru(): array
    {
        $tracerModel = new TracerModel();
        return $tracerModel->getTracerTerbaru(5);
    }

    /**
     * Get additional stats for dashboard cards
     */
    private function getAdditionalStats(): array
    {
        $alumniModel = new AlumniModel();
        $perusahaanModel = new PerusahaanModel();
        $lowonganModel = new LowonganModel();
        $pelamarModel = new PelamarModel();

        return [
            'alumni_last_month' => $alumniModel->getLastMonthAlumniCount(),
            'new_companies_last_month' => $perusahaanModel->getLastMonthNewCompanyCount(),
            'new_jobs_today' => $lowonganModel->getTodayActiveJobCount(),
            'new_pelamar_today' => $pelamarModel->getTodayPelamarCount(),
        ];
    }

    private function getRoleBasedTitle(int $role): string
    {
        return match($role) {
            1 => 'Selamat Datang, Super Admin',
            2 => 'Selamat Datang, Admin BKK',
            default => 'Selamat Datang'
        };
    }

    public function index()
    {
        $idRole = session()->get('id_role');
        $userId = session()->get('id');

        // Role 3 = DUDI/Perusahaan
        if ($idRole == 3) {
            $db = \Config\Database::connect();

            $perusahaanModel = new PerusahaanModel();
            $company = $perusahaanModel->where('id_user', $userId)->first();

            if (!$company) {
                return view('admin/dashboard_dudi', [
                    'title'           => 'Dashboard Perusahaan',
                    'company'         => null,
                    'id_perusahaan'   => null,
                    'namaPerusahaan'  => 'Perusahaan',
                    'totalLowongan'   => 0,
                    'totalLamaran'    => 0,
                    'totalDiproses'   => 0,
                    'totalDiterima'   => 0,
                    'chartData'       => [],
                    'lamaranTerbaru'  => [],
                    'activeJobs'      => [],
                    'profileComplete' => false,
                ]);
            }

            $idPerusahaan = $company['id'];

            // Total lowongan aktif — pakai kolom sesuai LowonganModel (posisi, status)
            $lowonganModel = new LowonganModel();
            $lowongans     = $lowonganModel
                ->where('id_perusahaan', $idPerusahaan)
                ->where('status', 'aktif')
                ->findAll();
            $totalLowongan = count($lowongans);

            // Ambil semua id lamaran milik perusahaan ini
            $lamaranRows = $db->table('tb_lamaran')
                ->select('tb_lamaran.id')
                ->join('tb_lowongan', 'tb_lowongan.id = tb_lamaran.id_lowongan')
                ->where('tb_lowongan.id_perusahaan', $idPerusahaan)
                ->get()->getResultArray();

            $lamaranIds   = array_column($lamaranRows, 'id');
            $totalLamaran = count($lamaranIds);
            $safeIds      = !empty($lamaranIds) ? $lamaranIds : [0];

            // Count by status — sesuai nilai status di LamaranModel
            $totalDiproses = $db->table('tb_lamaran')
                ->whereIn('id', $safeIds)
                ->where('status', 'diproses')
                ->countAllResults();

            $totalDiterima = $db->table('tb_lamaran')
                ->whereIn('id', $safeIds)
                ->where('status', 'diterima')
                ->countAllResults();

            $totalBaru = $db->table('tb_lamaran')
                ->whereIn('id', $safeIds)
                ->where('status', 'menunggu_diverifikasi')
                ->countAllResults();

            // Chart data: 7 hari terakhir — pakai tanggal_melamar dari LamaranModel
            $chartData = [];
            for ($i = 6; $i >= 0; $i--) {
                $date  = date('Y-m-d', strtotime("-$i days"));
                $count = $db->table('tb_lamaran')
                    ->select('COUNT(tb_lamaran.id) as total')
                    ->join('tb_lowongan', 'tb_lowongan.id = tb_lamaran.id_lowongan')
                    ->where('tb_lowongan.id_perusahaan', $idPerusahaan)
                    ->where('DATE(tb_lamaran.tanggal_melamar)', $date)
                    ->get()->getRowArray();
                $chartData[] = (int)($count['total'] ?? 0);
            }

            // Lamaran terbaru (5 terakhir)
            // tb_pelamar join via id_pelamar, nama dari tb_users via id_user
            $recentLamaran = $db->table('tb_lamaran')
                ->select('tb_lamaran.*, tb_users.nama as nama_lengkap, tb_lowongan.posisi, tb_lamaran.status')
                ->join('tb_lowongan', 'tb_lowongan.id = tb_lamaran.id_lowongan')
                ->join('tb_pelamar', 'tb_pelamar.id = tb_lamaran.id_pelamar')
                ->join('tb_users', 'tb_users.id = tb_pelamar.id_user')
                ->where('tb_lowongan.id_perusahaan', $idPerusahaan)
                ->orderBy('tb_lamaran.tanggal_melamar', 'DESC')
                ->limit(5)
                ->get()->getResultArray();

            // Lowongan aktif beserta jumlah pelamar
            // pakai kolom 'posisi' sesuai LowonganModel (bukan posisi_kerja)
            $activeJobs = [];
            foreach ($lowongans as $lowongan) {
                $jumlahLamaran = $db->table('tb_lamaran')
                    ->where('id_lowongan', $lowongan['id'])
                    ->countAllResults();
                $activeJobs[] = [
                    'id'              => $lowongan['id'],
                    'posisi'          => $lowongan['posisi'],
                    'jenis_pekerjaan' => $lowongan['jenis_pekerjaan'] ?? '-',
                    'lokasi_kerja'    => $lowongan['lokasi_kerja'] ?? '-',
                    'jumlah_pelamar'  => $jumlahLamaran,
                    'batas_lamaran'   => $lowongan['batas_lamaran'] ?? null,
                ];
            }

            // Cek kelengkapan profil — sesuai allowedFields PerusahaanModel
            // (tidak ada kolom deskripsi, pakai: alamat, logo, website, no_telepon)
            $profileComplete = !empty($company['alamat'])     &&
                !empty($company['logo'])       &&
                !empty($company['website'])    &&
                !empty($company['no_telepon']);

            return view('admin/dashboard_dudi', [
                'title'           => 'Dashboard Perusahaan',
                'company'         => $company,
                'id_perusahaan'   => $idPerusahaan,
                'namaPerusahaan'  => $company['nama_perusahaan'] ?? 'Perusahaan',
                'totalLowongan'   => $totalLowongan,
                'totalLamaran'    => $totalLamaran,
                'totalDiproses'   => $totalDiproses,
                'totalDiterima'   => $totalDiterima,
                'totalBaru'       => $totalBaru,
                'chartData'       => $chartData,
                'lamaranTerbaru'  => $recentLamaran,
                'activeJobs'      => $activeJobs,
                'profileComplete' => $profileComplete,
            ]);
        }

        // Default admin dashboard (role 1, 2)
        $tracerModel       = new TracerModel();
        $perusahaanModel   = new PerusahaanModel();
        $lowonganModel     = new LowonganModel();
        $pelamarModel      = new PelamarModel();
        $alumniModel       = new AlumniModel();

        // Get additional stats for comparison
        $additionalStats = $this->getAdditionalStats();

        return view('admin/dashboard', [
            // Stats utama
            'totalAlumni'     => $this->getTotalAlumni(),
            'totalPerusahaan' => $this->getTotalPerusahaan(),
            'totalLowongan'   => $this->getTotalLowongan(),
            'totalPelamar'    => $this->getTotalPelamar(),

            // Additional metrics untuk card
            'alumniLastMonth'       => $additionalStats['alumni_last_month'],
            'newCompaniesLastMonth' => $additionalStats['new_companies_last_month'],
            'newJobsToday'          => $additionalStats['new_jobs_today'],
            'newPelamarToday'       => $additionalStats['new_pelamar_today'],

            // Chart data
            'tracerChartLabels' => $this->getTracerChart()['labels'],
            'tracerChartData'   => $this->getTracerChart()['data'],

            // Pie chart data
            'statusAlumniData' => $this->getStatusAlumni(),

            // Table data
            'tracerTerbaru' => $this->getTracerTerbaru(),

            // Active companies list
            'perusahaanAktif' => $this->getPerusahaanAktif(),

            // Role info
            'userRole' => $idRole,
        ]);
    }
}
