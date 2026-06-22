<?php

namespace App\Controllers;

class TracerAlumni extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $totalBekerja = (int) $db->table('tb_tracer_alumni')
            ->where('status', 'disetujui')
            ->where('posisi_kerja IS NOT NULL', null, false)
            ->where('nama_usaha IS NULL', null, false)
            ->countAllResults();

        $totalWirausaha = (int) $db->table('tb_tracer_alumni')
            ->where('status', 'disetujui')
            ->where('nama_usaha IS NOT NULL', null, false)
            ->countAllResults();

        $totalStudi = (int) $db->table('tb_tracer_alumni')
            ->where('status', 'disetujui')
            ->where('universitas IS NOT NULL', null, false)
            ->countAllResults();

        $relevansi = $db->table('tb_tracer_alumni')
            ->select('AVG(is_relevan_jurusan) * 100 AS pct_relevan', false)
            ->where('status', 'disetujui')
            ->get()
            ->getRowArray();

        $topBidangDudi = $db->table('tb_tracer_alumni')
            ->select('bidang_dudi AS label, COUNT(*) AS total', false)
            ->where('status', 'disetujui')
            ->where('bidang_dudi IS NOT NULL', null, false)
            ->where('bidang_dudi !=', '')
            ->groupBy('bidang_dudi')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $topPerusahaan = $db->table('tb_tracer_alumni')
            ->select('nama_dudi AS label, COUNT(*) AS total', false)
            ->where('status', 'disetujui')
            ->where('nama_dudi IS NOT NULL', null, false)
            ->where('nama_dudi !=', '')
            ->groupBy('nama_dudi')
            ->orderBy('total', 'DESC')
            ->limit(6)
            ->get()
            ->getResultArray();

        $statusAlumni = $db->table('tb_tracer_alumni ta')
            ->select('tb_aktivitas.nama_aktivitas, COUNT(ta.id) as total')
            ->join('tb_aktivitas', 'tb_aktivitas.id = ta.id_aktivitas', 'left')
            ->where('ta.status', 'disetujui')
            ->groupBy('ta.id_aktivitas')
            ->get()
            ->getResultArray();

        $statusCounts = [
            'Bekerja' => 0,
            'Kuliah' => 0,
            'Wirausaha' => 0,
            'Belum Bekerja' => 0
        ];

        foreach ($statusAlumni as $item) {
            $nama = strtolower($item['nama_aktivitas'] ?? '');
            $total = (int) ($item['total'] ?? 0);

            if (strpos($nama, 'bekerja') !== false) {
                $statusCounts['Bekerja'] += $total;
            } elseif (strpos($nama, 'kuliah') !== false || strpos($nama, 'stud') !== false) {
                $statusCounts['Kuliah'] += $total;
            } elseif (strpos($nama, 'wirausaha') !== false || strpos($nama, 'usaha') !== false) {
                $statusCounts['Wirausaha'] += $total;
            } else {
                $statusCounts['Belum Bekerja'] += $total;
            }
        }

        $statusAlumniData = [];
        foreach ($statusCounts as $label => $value) {
            if ($value > 0) {
                $statusAlumniData[] = ['label' => $label, 'value' => $value];
            }
        }

        $data = [
            'title' => 'Tracer Alumni',
            'total_bekerja' => $totalBekerja,
            'total_wirausaha' => $totalWirausaha,
            'total_studi' => $totalStudi,
            'pct_relevan' => (float) ($relevansi['pct_relevan'] ?? 0),
            'top_bidang_dudi' => $topBidangDudi,
            'top_perusahaan' => $topPerusahaan,
            'status_alumni' => $statusAlumniData,
        ];

        return view('landing/tracer_alumni/index', $data);
    }
}