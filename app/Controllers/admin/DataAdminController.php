<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\RoleModel;
use App\Models\UserModel;
use App\Models\PerusahaanModel;


class DataAdminController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $roleModel = new RoleModel();
        $perusahaanModel = new PerusahaanModel();

        $admins = $userModel->getAdmin();
        // Jika admin BKK (role 2), sembunyikan super admin (role 1)
        if (session()->get('id_role') == 2) {
            $admins = array_filter($admins, function ($admin) {
                return $admin['id_role'] != 1;
            });
        }
        $data['admins'] = $admins;

        // Jika admin BKK, sembunyikan opsi super admin di dropdown
        if (session()->get('id_role') == 2) {
            $data['roles']  = $roleModel
                ->whereIn('id', [2, 3])
                ->findAll();
        } else {
            $data['roles']  = $roleModel
                ->whereIn('id', [1, 2, 3])
                ->findAll();
        }

        $data['perusahaan'] = $perusahaanModel->where('id_user IS NULL', null, false)->findAll();
        $data['semua_perusahaan'] = $perusahaanModel->findall();

        return view('admin/data_admin/index', $data);
    }

    public function store()
    {
        $userModel = new UserModel();
        $adminModel = new AdminModel();
        $perusahaanModel = new PerusahaanModel();

        $validationRules = [
            'nama'     => 'required|max_length[100]',
            'email'    => 'required|valid_email|max_length[100]|is_unique[tb_users.email]',
            'password' => 'required|strong_password',
            'id_role'  => 'required|in_list[1,2,3]',
        ];

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $Userdata = [
            'id_role' => $this->request->getPost('id_role'),
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'is_active' => 1,
            'is_verified' => 1,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'email_token' => null,
        ];
        if (!$userModel->insert($Userdata)) {
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }

        $userId = $userModel->insertID();

        $adminData = [
            'id_user' => $userId,
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'telepon' => $this->request->getPost('telepon'),
            'alamat' => $this->request->getPost('alamat'),

        ];
        // handle upload foto
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move('uploads/foto/', $namaFile);
            $adminData['foto'] = $namaFile;
        }

        $adminModel->insert($adminData);

        $idRole = $this->request->getPost('id_role');
        $idPerusahaan = $this->request->getPost('id_perusahaan');
        if ($idRole == 3 && $idPerusahaan) {
            $perusahaanModel->update($idPerusahaan, ['id_user' => $userId]);
        }

        return redirect()->to('/admin/data-admin')->with('success', 'Data berhasil ditambahkan');
    }

    public function profil($id)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('tb_users')
            ->select('tb_users.id, tb_users.id_role, tb_users.nama, tb_users.email, tb_users.is_active, tb_users.is_verified, tb_users.last_login, tb_users.created_at, tb_users.updated_at')
            ->select('tb_roles.nama_role')
            ->select('tb_admin.jenis_kelamin, tb_admin.tempat_lahir, tb_admin.tanggal_lahir, tb_admin.telepon, tb_admin.alamat, tb_admin.foto')
            ->select('tb_perusahaan.id as id_perusahaan, tb_perusahaan.nama_perusahaan, tb_perusahaan.bidang_usaha, tb_perusahaan.alamat as alamat_perusahaan, tb_perusahaan.kota, tb_perusahaan.no_telepon, tb_perusahaan.email as email_perusahaan, tb_perusahaan.website, tb_perusahaan.logo, tb_perusahaan.is_active as perusahaan_is_active, tb_perusahaan.created_at as perusahaan_created_at, tb_perusahaan.updated_at as perusahaan_updated_at')
            ->join('tb_roles', 'tb_roles.id = tb_users.id_role', 'left')
            ->join('tb_admin', 'tb_admin.id_user = tb_users.id', 'left')
            ->join('tb_perusahaan', 'tb_perusahaan.id_user = tb_users.id', 'left')
            ->where('tb_users.id', $id)
            ->whereIn('tb_users.id_role', [1, 2, 3]);

        if ((int) session()->get('id_role') === 2) {
            $builder->whereIn('tb_users.id_role', [2, 3]);
        }

        $admin = $builder->get()->getRowArray();

        if (!$admin) {
            return redirect()->to('/admin/data-admin')->with('error', 'Data admin tidak ditemukan.');
        }

        $perusahaan = null;
        if ((int) ($admin['id_role'] ?? 0) === 3 && !empty($admin['id_perusahaan'])) {
            $perusahaan = [
                'id'              => $admin['id_perusahaan'],
                'id_user'         => $admin['id'],
                'nama_perusahaan' => $admin['nama_perusahaan'],
                'bidang_usaha'    => $admin['bidang_usaha'],
                'alamat'          => $admin['alamat_perusahaan'],
                'kota'            => $admin['kota'],
                'no_telepon'      => $admin['no_telepon'],
                'email'           => $admin['email_perusahaan'],
                'website'         => $admin['website'],
                'logo'            => $admin['logo'],
                'is_active'       => $admin['perusahaan_is_active'],
                'created_at'      => $admin['perusahaan_created_at'],
                'updated_at'      => $admin['perusahaan_updated_at'],
            ];
        }

        return view('admin/data_admin/profil', [
            'title'      => 'Profil Admin',
            'admin'      => $admin,
            'perusahaan' => $perusahaan,
        ]);
    }

    public function editProfil($id)
    {
        $roleId = (int) session()->get('id_role');

        if (!in_array($roleId, [1, 2], true)) {
            return redirect()->to('/admin/data-admin/' . $id . '/profil')->with('error', 'Tidak memiliki akses');
        }

        $db = \Config\Database::connect();

        $builder = $db->table('tb_users')
            ->select('tb_users.id, tb_users.id_role, tb_users.nama, tb_users.email, tb_users.is_active, tb_users.is_verified, tb_users.last_login, tb_users.created_at, tb_users.updated_at')
            ->select('tb_roles.nama_role')
            ->select('tb_admin.jenis_kelamin, tb_admin.tempat_lahir, tb_admin.tanggal_lahir, tb_admin.telepon, tb_admin.alamat, tb_admin.foto')
            ->select('tb_perusahaan.id as id_perusahaan, tb_perusahaan.nama_perusahaan, tb_perusahaan.bidang_usaha, tb_perusahaan.alamat as alamat_perusahaan, tb_perusahaan.kota, tb_perusahaan.no_telepon, tb_perusahaan.email as email_perusahaan, tb_perusahaan.website, tb_perusahaan.logo, tb_perusahaan.is_active as perusahaan_is_active, tb_perusahaan.created_at as perusahaan_created_at, tb_perusahaan.updated_at as perusahaan_updated_at')
            ->join('tb_roles', 'tb_roles.id = tb_users.id_role', 'left')
            ->join('tb_admin', 'tb_admin.id_user = tb_users.id', 'left')
            ->join('tb_perusahaan', 'tb_perusahaan.id_user = tb_users.id', 'left')
            ->where('tb_users.id', $id)
            ->whereIn('tb_users.id_role', [1, 2, 3]);

        if ((int) session()->get('id_role') === 2) {
            $builder->whereIn('tb_users.id_role', [2, 3]);
        }

        $admin = $builder->get()->getRowArray();

        if (!$admin) {
            return redirect()->to('/admin/data-admin')->with('error', 'Data admin tidak ditemukan.');
        }

        $perusahaan = null;
        if ((int) ($admin['id_role'] ?? 0) === 3 && !empty($admin['id_perusahaan'])) {
            $perusahaan = [
                'id'              => $admin['id_perusahaan'],
                'id_user'         => $admin['id'],
                'nama_perusahaan' => $admin['nama_perusahaan'],
                'bidang_usaha'    => $admin['bidang_usaha'],
                'alamat'          => $admin['alamat_perusahaan'],
                'kota'            => $admin['kota'],
                'no_telepon'      => $admin['no_telepon'],
                'email'           => $admin['email_perusahaan'],
                'website'         => $admin['website'],
                'logo'            => $admin['logo'],
                'is_active'       => $admin['perusahaan_is_active'],
                'created_at'      => $admin['perusahaan_created_at'],
                'updated_at'      => $admin['perusahaan_updated_at'],
            ];
        }

        return view('admin/data_admin/edit_profil', [
            'title'      => 'Edit Profil Admin',
            'admin'      => $admin,
            'perusahaan' => $perusahaan,
        ]);
    }

    public function updateProfil($id)
    {
        $roleId = (int) session()->get('id_role');

        if (!in_array($roleId, [1, 2], true)) {
            return redirect()->to('/admin/data-admin/' . $id . '/profil')->with('error', 'Tidak memiliki akses');
        }

        $validationRules = [
            'nama'    => 'required|max_length[100]',
            'email'   => 'required|valid_email|max_length[100]|is_unique[tb_users.email,id,' . $id . ']',
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

        $db->table('tb_users')->where('id', $id)->update($userData);

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
            }

            $adminData['foto'] = $namaFile;
        }

        $db->table('tb_admin')->where('id_user', $id)->update($adminData);

        $targetRole = (int) ($this->request->getPost('target_role') ?? 0);
        if ($targetRole === 3 && !empty($this->request->getPost('id_perusahaan'))) {
            $perusahaanData = [
                'nama_perusahaan' => $this->request->getPost('nama_perusahaan'),
                'bidang_usaha'    => $this->request->getPost('bidang_usaha'),
                'alamat'          => $this->request->getPost('alamat'),
                'kota'            => $this->request->getPost('kota'),
                'no_telepon'      => $this->request->getPost('no_telepon'),
                'email'           => $this->request->getPost('email_perusahaan'),
                'website'         => $this->request->getPost('website'),
            ];
            $db->table('tb_perusahaan')->where('id', $this->request->getPost('id_perusahaan'))->update($perusahaanData);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui profil.');
        }

        return redirect()->to('/admin/data-admin/' . $id . '/profil')->with('success', 'Profil admin berhasil diperbarui.');
    }


    public function update($id)
    {
        $userModel = new UserModel();
        $adminModel = new AdminModel();
        $perusahaanModel = new PerusahaanModel();

        $validationRules = [
            'nama'     => 'required',
            'email'    => 'required|valid_email|is_unique[tb_users.email,id,' . $id . ']',
            'id_role'  => 'required',
        ];

        $password = $this->request->getPost('password');
        if ($password !== null && $password !== '') {
            $validationRules['password'] = 'strong_password';
        }

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userData = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'is_active' => $this->request->getPost('is_active'),
            'id_role' => $this->request->getPost('id_role'),
            'is_verified' => 1,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'email_token' => null,
        ];

        if ($password) {
            $userData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $userModel->update($id, $userData);
        $adminData = [
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'telepon' => $this->request->getPost('telepon'),
            'alamat' => $this->request->getPost('alamat'),
        ];
        // upload foto (kalau ada)
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move('uploads/foto/', $namaFile);
            $adminData['foto'] = $namaFile;
        }
        $adminModel->where('id_user', $id)->set($adminData)->update();

        $idRole = $this->request->getPost('id_role');
        $idPerusahaan = $this->request->getPost('id_perusahaan');

        // Kosongkan id_user di perusahaan lama (jika ada)
        $perusahaanModel->where('id_user', $id)->set(['id_user' => null])->update();

        // Isi id_user di perusahaan baru jika role DU/DI
        if ($idRole == 3 && $idPerusahaan) {
            $perusahaanModel->update($idPerusahaan, ['id_user' => $id]);
        }
        return redirect()->to('/admin/data-admin')->with('success', 'Data berhasil diupdate');
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $userModel = new UserModel();
        $adminModel = new AdminModel();

        $db->table('tb_perusahaan')
            ->where('id_user', $id)
            ->update(['id_user' => null]);

        $adminModel->where('id_user', $id)->delete();
        $userModel->delete($id);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menghapus data');
        }

        return redirect()->to('/admin/data-admin')->with('success', 'Data admin berhasil dihapus');
    }
}
