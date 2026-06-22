<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PerusahaanModel;

class ProfilPerusahaanController extends BaseController
{
    protected PerusahaanModel $perusahaanModel;

    public function __construct()
    {
        $this->perusahaanModel = new PerusahaanModel();
    }

    public function index()
    {
        $perusahaan = $this->getPerusahaanLogin();

        return view('admin/profil_perusahaan/index', [
            'title'      => 'Profil Perusahaan',
            'perusahaan' => $perusahaan,
        ]);
    }

    public function update()
    {
        $perusahaan = $this->getPerusahaanLogin();

        if (!$perusahaan) {
            return redirect()->back()->with('error', 'Data perusahaan untuk akun ini tidak ditemukan.');
        }

        $rules = [
            'nama_perusahaan' => 'required|max_length[150]',
            'bidang_usaha'    => 'required|max_length[100]',
            'alamat'          => 'required',
            'kota'            => 'required|max_length[100]',
            'no_telepon'      => 'required|max_length[20]',
            'email'           => 'required|valid_email|max_length[100]',
            'website'         => 'permit_empty|valid_url|max_length[150]',
            'logo'            => 'permit_empty|max_size[logo,2048]|is_image[logo]|mime_in[logo,image/jpg,image/jpeg,image/png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_perusahaan' => $this->request->getPost('nama_perusahaan'),
            'bidang_usaha'    => $this->request->getPost('bidang_usaha'),
            'alamat'          => $this->request->getPost('alamat'),
            'kota'            => $this->request->getPost('kota'),
            'no_telepon'      => $this->request->getPost('no_telepon'),
            'email'           => $this->request->getPost('email'),
            'website'         => $this->request->getPost('website'),
        ];

        $logo = $this->request->getFile('logo');
        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            $logoName = $logo->getRandomName();
            $logo->move(FCPATH . 'uploads/logo', $logoName);
            $data['logo'] = $logoName;
        }

        $updated = $this->perusahaanModel
            ->where('id', $perusahaan['id'])
            ->where('id_user', session()->get('id'))
            ->set($data)
            ->update();

        if (!$updated) {
            return redirect()->back()->withInput()->with('error', 'Profil perusahaan gagal diperbarui.');
        }

        return redirect()->to('/admindudi/profil-perusahaan')->with('success', 'Profil perusahaan berhasil diperbarui.');
    }

    private function getPerusahaanLogin(): ?array
    {
        return $this->perusahaanModel
            ->where('id_user', session()->get('id'))
            ->first();
    }
}
