<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\PelamarModel;
use App\Models\UserModel;
use App\Models\AlumniModel;
use App\Models\TracerModel;

class DataPelamarController extends BaseController
{
    private const STATUS_PENDAFTARAN = [
        'menunggu_aktivasi',
        'terdaftar',
        'aktif',
    ];

    public function index()
    {
        $pelamarModel = new PelamarModel();

        $data['pelamars'] = $pelamarModel->getPelamarWithUser();


        return view('admin/data_pelamar/index', $data);
    }

    public function store()
    {
        $userModel = new UserModel();
        $pelamarModel = new PelamarModel();
        $alumniModel = new AlumniModel();
        $tracerModel = new TracerModel();
        $db = \Config\Database::connect();

        $jenisPelamar = $this->request->getPost('jenis_pelamar');
        $Userdata = [
            'id_role' => $this->getRoleIdByJenisPelamar($jenisPelamar),
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'is_active' => 1,
        ];
        $pelamarData = [
            'jenis_pelamar' => $this->request->getPost('jenis_pelamar'),
            'telepon' => $this->request->getPost('telepon'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'alamat' => $this->request->getPost('alamat'),
            'nomer_nik' => $this->request->getPost('nomer_nik'),
        ];
        // handle upload foto
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move('uploads/foto/', $namaFile);
            $pelamarData['foto'] = $namaFile;
        }

        $db->transStart();

        $userId = $userModel->insert($Userdata, true);
        $pelamarData['id_user'] = $userId;
        $pelamarId = $pelamarModel->insert($pelamarData, true);

        if (strtolower((string) $jenisPelamar) === 'alumni') {
            $alumniId = $alumniModel->insert([
                'id_pelamar' => $pelamarId,
            ], true);

            $tracerModel->insert([
                'id_alumni'    => $alumniId,
                'id_aktivitas' => null,
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Data gagal ditambahkan');
        }

        return redirect()->to('/admin/data-pelamar')->with('success', 'Data berhasil ditambahkan');
    }

    public function update($id)
    {
        $userModel = new UserModel();
        $pelamarModel = new PelamarModel();
        $alumniModel = new AlumniModel();
        $tracerModel = new TracerModel();
        $db = \Config\Database::connect();

        $validationRules = [
            'nama'     => 'required',
            'email'    => 'required|valid_email',
            'jenis_pelamar'  => 'required',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userData = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'is_active' => $this->request->getPost('is_active'),
        ];

        // Only update password if provided
        if ($this->request->getPost('password')) {
            $userData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $jenisPelamar = $this->request->getPost('jenis_pelamar');
        $userData['id_role'] = $this->getRoleIdByJenisPelamar($jenisPelamar);

        $db->transStart();

        $userModel->update($id, $userData);
        $pelamarData = [
            'jenis_pelamar' => $jenisPelamar,
            'telepon' => $this->request->getPost('telepon'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'alamat' => $this->request->getPost('alamat'),
            'nomer_nik' => $this->request->getPost('nomer_nik'),
        ];
        // upload foto (kalau ada)
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move('uploads/foto/', $namaFile);
            $pelamarData['foto'] = $namaFile;
        }
        $pelamarModel->where('id_user', $id)->set($pelamarData)->update();

        $pelamar = $pelamarModel->getByUserId($id);

        if ($pelamar && strtolower((string) $jenisPelamar) === 'alumni') {
            $alumni = $alumniModel->getByPelamar($pelamar['id']);
            $alumniId = $alumni['id'] ?? $alumniModel->insert([
                'id_pelamar' => $pelamar['id'],
            ], true);

            $tracer = $tracerModel->getByAlumni($alumniId);
            if (!$tracer) {
                $tracerModel->insert([
                    'id_alumni'    => $alumniId,
                    'id_aktivitas' => null,
                ]);
            }
        }

        if ($pelamar && strtolower((string) $jenisPelamar) === 'umum') {
            $alumni = $alumniModel->getByPelamar($pelamar['id']);

            if ($alumni) {
                $tracer = $tracerModel->getByAlumni($alumni['id']);
                if ($tracer) {
                    $tracerModel->delete($tracer['id']);
                }

                $alumniModel->delete($alumni['id']);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Data gagal diupdate');
        }

        return redirect()->to('/admin/data-pelamar')->with('success', 'Data berhasil diupdate');
    }

    public function updateStatusPendaftaran($id)
    {
        $pelamarModel = new PelamarModel();
        $statusPendaftaran = (string) $this->request->getPost('status_pendaftaran');

        if (!in_array($statusPendaftaran, self::STATUS_PENDAFTARAN, true)) {
            return redirect()->back()->with('error', 'Status pendaftaran tidak valid');
        }

        $pelamar = $pelamarModel->where('id_user', $id)->first();
        if (!$pelamar) {
            return redirect()->back()->with('error', 'Data pelamar tidak ditemukan');
        }

        $now = date('Y-m-d H:i:s');
        $updateData = [
            'status_pendaftaran' => $statusPendaftaran,
        ];

        if ($statusPendaftaran === 'menunggu_aktivasi') {
            $updateData['terdaftar_pada'] = null;
            $updateData['diaktivasi_oleh'] = null;
            $updateData['diaktivasi_pada'] = null;
        }

        if ($statusPendaftaran === 'terdaftar') {
            $updateData['terdaftar_pada'] = $pelamar['terdaftar_pada'] ?? $now;
            $updateData['diaktivasi_oleh'] = null;
            $updateData['diaktivasi_pada'] = null;
        }

        if ($statusPendaftaran === 'aktif') {
            $updateData['terdaftar_pada'] = $pelamar['terdaftar_pada'] ?? $now;
            $updateData['diaktivasi_oleh'] = (int) session()->get('id');
            $updateData['diaktivasi_pada'] = $now;
        }

        $pelamarModel->update($pelamar['id'], $updateData);

        return redirect()->to('/admin/data-pelamar')->with('success', 'Status pendaftaran berhasil diperbarui');
    }

    private function getRoleIdByJenisPelamar($jenisPelamar)
    {
        $jenis = strtolower($jenisPelamar);
        if ($jenis === 'alumni') {
            return 4;
        }

        if ($jenis === 'umum') {
            return 5;
        }

        return 2;
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $userModel = new UserModel();
        $pelamarModel = new PelamarModel();
        $alumniModel = new AlumniModel();
        $tracerModel = new TracerModel();

        $pelamar = $pelamarModel->getByUserId($id);
        if ($pelamar) {
            $alumni = $alumniModel->getByPelamar($pelamar['id']);

            if ($alumni) {
                $tracer = $tracerModel->getByAlumni($alumni['id']);
                if ($tracer) {
                    $tracerModel->delete($tracer['id']);
                }

                $alumniModel->delete($alumni['id']);
            }
        }

        $pelamarModel->where('id_user', $id)->delete();
        $userModel->delete($id);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menghapus data');
        }

        return redirect()->to('/admin/data-pelamar')->with('success', 'Data pelamar berhasil dihapus');
    }
}
