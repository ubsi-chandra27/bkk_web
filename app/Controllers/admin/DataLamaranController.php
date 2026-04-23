<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LamaranModel;
use App\Models\PelamarModel;
use App\Models\LowonganModel;
use App\Models\PerusahaanModel;
use App\Models\UserModel;

class DataLamaranController extends BaseController
{
    protected $lamaranModel;
    protected $pelamarModel;
    protected $lowonganModel;
    protected $perusahaanModel;
    protected $userModel;

    public function __construct()
    {
        $this->lamaranModel = new LamaranModel();
        $this->pelamarModel = new PelamarModel();
        $this->lowonganModel = new LowonganModel();
        $this->perusahaanModel = new PerusahaanModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $lamaran = $this->lamaranModel->select('tb_lamaran.*, 
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
            ->orderBy('tb_lamaran.created_at', 'DESC')
            ->findAll();

        $data = [
            'lamaran' => $lamaran,
            'title' => 'Data Lamaran'
        ];



        return view('admin/data_lamaran/index', $data);
    }



    public function update($id)
    {
        $lamaran = $this->lamaranModel->find($id);
        if (!$lamaran) {
            return redirect()->back()->with('error', 'Data lamaran tidak ditemukan');
        }

        $rules = [
            'status' => 'required|in_list[menunggu,menunggu_diverifikasi,disetujui,lolos_verifikasi,wawancara,tidak_lolos,diverifikasi,diproses,lolos verifikasi,tidak lolos]',
            'catatan' => 'permit_empty|string|max_length[500]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'status' => $this->request->getPost('status'),
            'catatan' => $this->request->getPost('catatan'),
            'dibuat_oleh' => session()->get('id'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->lamaranModel->update($id, $data)) {
            return redirect()->back()->with('success', 'Status lamaran berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui status lamaran');
        }
    }

    public function delete($id)
    {
        $lamaran = $this->lamaranModel->find($id);
        if (!$lamaran) {
            return redirect()->to('/admin/data-lamaran')->with('error', 'Data lamaran tidak ditemukan');
        }

        if ($this->lamaranModel->delete($id)) {
            return redirect()->to('/admin/data-lamaran')->with('success', 'Data lamaran berhasil dihapus');
        } else {
            return redirect()->to('/admin/data-lamaran')->with('error', 'Gagal menghapus data lamaran');
        }
    }
}
