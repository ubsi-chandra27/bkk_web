<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\TracerModel;
use App\Models\PerusahaanModel;
use App\Models\LowonganModel;
use App\Models\PelamarModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $tracerModel = new TracerModel();
        $perusahaanModel = new PerusahaanModel();
        $lowonganModel = new LowonganModel();
        $pelamarModel = new PelamarModel();

        $data['totalAlumni'] = $tracerModel->countAll();
        $data['totalPerusahaan'] = $perusahaanModel->countAll();
        $data['totalLowongan'] = $lowonganModel->countAll();
        $data['totalPelamar'] = $pelamarModel->countAll();

        return view('admin/dashboard', $data);
    }
}
