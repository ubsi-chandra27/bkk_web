<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class ProfilSayaController extends BaseController
{
    public function index()
    {
        $userId = (int) session()->get('id');
        $roleId = (int) session()->get('id_role');

        if ($userId <= 0) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $db = \Config\Database::connect();

        $builder = $db->table('tb_users')
            ->select('tb_users.id, tb_users.id_role, tb_users.nama, tb_users.email, tb_users.is_active, tb_users.is_verified, tb_users.last_login, tb_users.created_at, tb_users.updated_at')
            ->select('tb_roles.nama_role')
            ->select('tb_admin.jenis_kelamin, tb_admin.tempat_lahir, tb_admin.tanggal_lahir, tb_admin.telepon, tb_admin.alamat, tb_admin.foto')
            ->join('tb_roles', 'tb_roles.id = tb_users.id_role', 'left')
            ->join('tb_admin', 'tb_admin.id_user = tb_users.id', 'left')
            ->where('tb_users.id', $userId);

        if ($roleId === 3) {
            $builder
                ->select('tb_perusahaan.id as id_perusahaan, tb_perusahaan.nama_perusahaan, tb_perusahaan.bidang_usaha, tb_perusahaan.alamat as alamat_perusahaan, tb_perusahaan.kota, tb_perusahaan.no_telepon, tb_perusahaan.email as email_perusahaan, tb_perusahaan.website, tb_perusahaan.logo, tb_perusahaan.is_active as perusahaan_is_active, tb_perusahaan.created_at as perusahaan_created_at, tb_perusahaan.updated_at as perusahaan_updated_at')
                ->join('tb_perusahaan', 'tb_perusahaan.id_user = tb_users.id', 'left');
        }

        $user = $builder
            ->get()
            ->getRowArray();

        if (!$user) {
            return redirect()->to('/dashboard')->with('error', 'Data user tidak ditemukan.');
        }

        $perusahaan = null;
        if ((int) ($user['id_role'] ?? 0) === 3 && !empty($user['id_perusahaan'])) {
            $perusahaan = [
                'id'              => $user['id_perusahaan'],
                'id_user'         => $user['id'],
                'nama_perusahaan' => $user['nama_perusahaan'],
                'bidang_usaha'    => $user['bidang_usaha'],
                'alamat'          => $user['alamat_perusahaan'],
                'kota'            => $user['kota'],
                'no_telepon'      => $user['no_telepon'],
                'email'           => $user['email_perusahaan'],
                'website'         => $user['website'],
                'logo'            => $user['logo'],
                'is_active'       => $user['perusahaan_is_active'],
                'created_at'      => $user['perusahaan_created_at'],
                'updated_at'      => $user['perusahaan_updated_at'],
            ];
        }

        return view('admin/profil_saya/index', [
            'title'      => 'Profil Saya',
            'user'       => $user,
            'perusahaan' => $perusahaan,
        ]);
    }

    public function edit()
    {
        $userId = (int) session()->get('id');
        $roleId = (int) session()->get('id_role');

        if ($userId <= 0) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $db = \Config\Database::connect();

        $builder = $db->table('tb_users')
            ->select('tb_users.id, tb_users.id_role, tb_users.nama, tb_users.email, tb_users.is_active, tb_users.is_verified, tb_users.last_login, tb_users.created_at, tb_users.updated_at')
            ->select('tb_roles.nama_role')
            ->select('tb_admin.jenis_kelamin, tb_admin.tempat_lahir, tb_admin.tanggal_lahir, tb_admin.telepon, tb_admin.alamat, tb_admin.foto')
            ->join('tb_roles', 'tb_roles.id = tb_users.id_role', 'left')
            ->join('tb_admin', 'tb_admin.id_user = tb_users.id', 'left')
            ->where('tb_users.id', $userId);

        if ($roleId === 3) {
            $builder
                ->select('tb_perusahaan.id as id_perusahaan, tb_perusahaan.nama_perusahaan, tb_perusahaan.bidang_usaha, tb_perusahaan.alamat as alamat_perusahaan, tb_perusahaan.kota, tb_perusahaan.no_telepon, tb_perusahaan.email as email_perusahaan, tb_perusahaan.website, tb_perusahaan.logo, tb_perusahaan.is_active as perusahaan_is_active, tb_perusahaan.created_at as perusahaan_created_at, tb_perusahaan.updated_at as perusahaan_updated_at')
                ->join('tb_perusahaan', 'tb_perusahaan.id_user = tb_users.id', 'left');
        }

        $user = $builder
            ->get()
            ->getRowArray();

        if (!$user) {
            return redirect()->to('/dashboard')->with('error', 'Data user tidak ditemukan.');
        }

        $perusahaan = null;
        if ((int) ($user['id_role'] ?? 0) === 3 && !empty($user['id_perusahaan'])) {
            $perusahaan = [
                'id'              => $user['id_perusahaan'],
                'id_user'         => $user['id'],
                'nama_perusahaan' => $user['nama_perusahaan'],
                'bidang_usaha'    => $user['bidang_usaha'],
                'alamat'          => $user['alamat_perusahaan'],
                'kota'            => $user['kota'],
                'no_telepon'      => $user['no_telepon'],
                'email'           => $user['email_perusahaan'],
                'website'         => $user['website'],
                'logo'            => $user['logo'],
                'is_active'       => $user['perusahaan_is_active'],
                'created_at'      => $user['perusahaan_created_at'],
                'updated_at'      => $user['perusahaan_updated_at'],
            ];
        }

        return view('admin/profil_saya/edit', [
            'title'      => 'Edit Profil',
            'user'       => $user,
            'perusahaan' => $perusahaan,
        ]);
    }

    public function update()
    {
        $userId = (int) session()->get('id');
        $roleId = (int) session()->get('id_role');

        if ($userId <= 0) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $validationRules = [
            'nama'    => 'required|max_length[100]',
            'email'   => 'required|valid_email|max_length[100]|is_unique[tb_users.email,id,' . $userId . ']',
            'telepon' => 'permit_empty|max_length[20]',
        ];

        $passwordBaru = $this->request->getPost('password');
        $konfirmasiPassword = $this->request->getPost('konfirmasi_password');

        if ($passwordBaru !== null && $passwordBaru !== '' || $konfirmasiPassword !== null && $konfirmasiPassword !== '') {
            $validationRules['password'] = 'required|strong_password';
            $validationRules['konfirmasi_password'] = 'required|matches[password]';
        }

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if ($passwordBaru !== null && $passwordBaru !== '' || $konfirmasiPassword !== null && $konfirmasiPassword !== '') {
            if (empty($passwordBaru) || empty($konfirmasiPassword)) {
                return redirect()->back()->withInput()->with('errors', ['password' => 'Password Baru dan Konfirmasi Password harus diisi kedua-duanya.']);
            }
            if ($passwordBaru !== $konfirmasiPassword) {
                return redirect()->back()->withInput()->with('errors', ['konfirmasi_password' => 'Konfirmasi Password tidak cocok.']);
            }
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $userData = [
            'nama'  => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
        ];

        if (!empty($passwordBaru)) {
            $userData['password'] = password_hash($passwordBaru, PASSWORD_DEFAULT);
        }

        $db->table('tb_users')->where('id', $userId)->update($userData);

        $adminData = [
            'telepon' => $this->request->getPost('telepon'),
        ];

        $file = $this->request->getFile('foto');
        $oldFoto = $this->request->getPost('old_foto');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileValidation = [
                'foto' => 'uploaded[foto]|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
            ];

            if (! $this->validate($fileValidation)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $namaFile = time() . '_' . $file->getRandomName();
            $file->move('uploads/foto/', $namaFile);

            if (!empty($oldFoto)) {
                @unlink('uploads/foto/' . $oldFoto);
                @unlink('uploads/foto/' . $oldFoto);
            }

            $adminData['foto'] = $namaFile;
        }

        $db->table('tb_admin')->where('id_user', $userId)->update($adminData);

        if ($roleId === 3 && !empty($this->request->getPost('id_perusahaan'))) {
            $perusahaanData = [
                'nama_perusahaan' => $this->request->getPost('nama_perusahaan'),
                'bidang_usaha'    => $this->request->getPost('bidang_usaha'),
                'alamat'          => $this->request->getPost('alamat'),
                'kota'            => $this->request->getPost('kota'),
                'no_telepon'      => $this->request->getPost('no_telepon_perusahaan'),
                'email'           => $this->request->getPost('email_perusahaan'),
                'website'         => $this->request->getPost('website'),
            ];
            $db->table('tb_perusahaan')->where('id', $this->request->getPost('id_perusahaan'))->update($perusahaanData);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui profil.');
        }

        return redirect()->to('/admin/profil-saya')->with('success', 'Profil berhasil diperbarui.');
    }
}
