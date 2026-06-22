<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LamaranModel;
use App\Models\PelamarModel;
use App\Models\LowonganModel;
use App\Models\PerusahaanModel;
use App\Models\UserModel;
use App\Models\LamaranStatusModel;
use App\Libraries\EmailNotifikasi;

class DataLamaranController extends BaseController
{
    protected $lamaranModel;
    protected $pelamarModel;
    protected $lowonganModel;
    protected $perusahaanModel;
    protected $userModel;
    protected $lamaranStatusModel;

    public function __construct()
    {
        $this->lamaranModel = new LamaranModel();
        $this->pelamarModel = new PelamarModel();
        $this->lowonganModel = new LowonganModel();
        $this->perusahaanModel = new PerusahaanModel();
        $this->userModel = new UserModel();
        $this->lamaranStatusModel = new LamaranStatusModel();
    }

    // 🔥 Helper ambil id_perusahaan dari user login
    private function getCompanyId()
    {
        $userId = session()->get('id');

        $perusahaan = $this->perusahaanModel
            ->where('id_user', $userId)
            ->first();

        return $perusahaan['id'] ?? null;
    }

    public function index()
    {
        $roleId = session()->get('id_role');
        $filters = [
            'perusahaan' => $this->request->getGet('perusahaan'),
            'posisi' => $this->request->getGet('posisi'),
        ];

        if ($roleId == 3) {
            $companyId = $this->getCompanyId();
            $lamaran = $this->lamaranModel->getFiltered($filters, $companyId);
        } else {
            $lamaran = $this->lamaranModel->getFiltered($filters);
        }

        return view('admin/data_lamaran/index', [
            'lamaran' => $lamaran,
            'filters' => $filters,
            'title' => 'Data Lamaran'
        ]);
    }

    public function update($id)
    {
        $lamaran = $this->lamaranModel->find($id);


        if (!$lamaran) {
            return redirect()->back()->with('error', 'Data lamaran tidak ditemukan');
        }

        $lowongan = $this->lowonganModel->find($lamaran['id_lowongan']);

        if (session()->get('id_role') == 3) {
            $companyId = $this->getCompanyId();

            if ($lowongan['id_perusahaan'] != $companyId) {
                return redirect()->back()->with('error', 'Akses ditolak');
            }
        }

        if (session()->get('id_role') == 2) {
            return redirect()->back()->with('error', 'Admin BKK tidak memiliki akses untuk mengubah status lamaran');
        }

        $statusBaru = (string) $this->request->getPost('status');
        $tanggalWawancara = $this->request->getPost('tanggal_wawancara') ?: null;

        $rules = [
            'status' => 'required|in_list[menunggu_diverifikasi,diproses,lolos_verifikasi,wawancara,tidak_lolos,diterima]',
            'tanggal_wawancara' => 'permit_empty|valid_date[Y-m-d]',
            'catatan' => 'permit_empty|string|max_length[500]'
        ];
        if ($statusBaru === 'wawancara') {
            $rules['tanggal_wawancara'] = 'required|valid_date[Y-m-d]';
        } else {
            $tanggalWawancara = null;
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $statusLama = $lamaran['status'];

        $statusBerubah = $statusBaru != $statusLama;

        if ($statusBerubah) {

            $statusModel = new LamaranStatusModel();

            $statusModel->insert([
                'id_lamaran'  => $id,
                'status_lama' => $statusLama,
                'status_baru' => $statusBaru,
                'catatan'     => $this->request->getPost('catatan'),
                'diubah_oleh' => session()->get('id'),
                // 'created_at'  => date('Y-m-d H:i:s')
            ]);
        }

        $this->lamaranModel->update($id, [
            'status' => $statusBaru,
            'catatan' => $this->request->getPost('catatan'),
            'tanggal_wawancara' => $tanggalWawancara,
            'dibuat_oleh' => session()->get('id')
            // 'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($statusBerubah) {
            // Kirim notifikasi ke pelamar saat status benar-benar berubah
            $notif = new \App\Libraries\NotificationService();
            $updatedLamaran = $this->lamaranModel->find($id);
            $notif->notifyApplicantStatusChanged($updatedLamaran, $statusBaru);
        }

        if (in_array($statusBaru, ['wawancara', 'diterima', 'ditolak', 'tidak_lolos'], true)) {
            try {
                $emailNotifikasi = new EmailNotifikasi();
                $emailNotifikasi->kirimStatusLamaran((int) $id, $statusBaru, $tanggalWawancara);
            } catch (\Throwable $e) {
                log_message('error', 'Gagal mengirim email status lamaran ID ' . $id . ': ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Status lamaran berhasil diperbarui');
    }

    public function delete($id)
    {
        $lamaran = $this->lamaranModel->find($id);

        if (!$lamaran) {
            return redirect()->to('/admin/data-lamaran')->with('error', 'Data lamaran tidak ditemukan');
        }

        $lowongan = $this->lowonganModel->find($lamaran['id_lowongan']);

        if (session()->get('role_id') == 3) {
            $companyId = $this->getCompanyId();

            if ($lowongan['id_perusahaan'] != $companyId) {
                return redirect()->back()->with('error', 'Akses ditolak');
            }
        }

        $this->lamaranModel->delete($id);

        return redirect()->to('/admin/data-lamaran')->with('success', 'Data lamaran berhasil dihapus');
    }

    public function riwayat()
    {

        $roleId = session()->get('role_id');

        if ($roleId == 3) {
            $companyId = $this->getCompanyId();
            $riwayat = $this->lamaranStatusModel->getAllRiwayat($companyId);
        } else {
            $riwayat = $this->lamaranStatusModel->getAllRiwayat();
        }

        return view('admin/riwayat_lamaran/index', [
            'title' => 'Riwayat Lamaran',
            'riwayat' => $riwayat
        ]);
    }
}
