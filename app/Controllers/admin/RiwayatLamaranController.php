<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\LamaranStatusModel;

class RiwayatLamaranController extends BaseController
{
    protected $lamaranStatusModel;

    public function __construct()
    {
        $this->lamaranStatusModel = new LamaranStatusModel();
    }

    public function index($idLamaran)
    {
        $riwayat = $this->lamaranStatusModel->getRiwayatByLamaran($idLamaran);

        return view('admin/riwayat_lamaran/index', [
            'riwayat' => $riwayat,
            'title' => 'Riwayat Lamaran'
        ]);
    }
}
