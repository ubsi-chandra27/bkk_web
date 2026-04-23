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

        $data['admins'] = $userModel->getAdmin();
        $data['roles']  = $roleModel
            ->whereIn('id', [1, 2, 3])
            ->findAll();
        $data['perusahaan'] = $perusahaanModel->where('id_user IS NULL', null, false)->findAll();
        $data['semua_perusahaan'] = $perusahaanModel->findall();


        return view('admin/data_admin/index', $data);
    }

    public function store()
    {
        $userModel = new UserModel();
        $adminModel = new AdminModel();
        $perusahaanModel = new PerusahaanModel();

        $Userdata = [
            'id_role' => $this->request->getPost('id_role'),
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'is_active' => 1,
        ];
        if (!$userModel->insert($Userdata)) {
            dd($userModel->errors());
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

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userData = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'is_active' => $this->request->getPost('is_active'),
            'id_role' => $this->request->getPost('id_role'),
        ];

        // Only update password if provided
        if ($this->request->getPost('password')) {
            $userData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
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

        $adminModel->where('id_user', $id)->delete();
        $userModel->delete($id);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menghapus data');
        }

        return redirect()->to('/admin/data-admin')->with('success', 'Data admin berhasil dihapus');
    }
}
