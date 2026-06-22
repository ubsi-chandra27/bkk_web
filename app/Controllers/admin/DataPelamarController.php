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
        $email = strtolower(trim((string) $this->request->getPost('email')));
        $plainPassword = (string) $this->request->getPost('password');

        $validationRules = [
            'nama'          => 'required|min_length[3]',
            'email'         => 'required|valid_email|is_unique[tb_users.email]',
            'password'      => 'required|min_length[6]',
            'jenis_pelamar' => 'required|in_list[alumni,umum]',
        ];

        $validationMessages = [
            'email' => [
                'is_unique' => 'Email sudah terdaftar. Gunakan email lain.',
            ],
        ];

        if (!$this->validate($validationRules, $validationMessages)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('error', implode(' ', $this->validator->getErrors()));
        }

        $Userdata = [
            'id_role' => $this->getRoleIdByJenisPelamar($jenisPelamar),
            'nama' => $this->request->getPost('nama'),
            'email' => $email,
            'password' => password_hash($plainPassword, PASSWORD_DEFAULT),
            'is_active' => 1,
            'is_verified' => 1,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'email_token' => null,
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

        $this->sendAdminCreatedAccountEmail(
            $email,
            (string) $this->request->getPost('nama'),
            $plainPassword
        );

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
            'email'    => 'required|valid_email|is_unique[tb_users.email,id,' . $id . ']',
            'jenis_pelamar'  => 'required|in_list[alumni,umum]',
            'password' => 'permit_empty|min_length[6]',
        ];

        $validationMessages = [
            'email' => [
                'is_unique' => 'Email sudah terdaftar. Gunakan email lain.',
            ],
        ];

        if (!$this->validate($validationRules, $validationMessages)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('error', implode(' ', $this->validator->getErrors()));
        }

        $email = strtolower(trim((string) $this->request->getPost('email')));
        $plainPassword = (string) $this->request->getPost('password');

        $userData = [
            'nama' => $this->request->getPost('nama'),
            'email' => $email,
            'is_active' => $this->request->getPost('is_active'),
            'is_verified' => (int) $this->request->getPost('is_verified'),
        ];

        if ((int) $this->request->getPost('is_verified') === 1) {
            $userData['email_verified_at'] = $userData['email_verified_at'] ?? date('Y-m-d H:i:s');
            $userData['email_token'] = null;
        } else {
            $userData['email_verified_at'] = null;
            $userData['email_token'] = null; // atau biarkan token lama jika perlu
        }

        // Only update password if provided
        if ($plainPassword !== '') {
            $userData['password'] = password_hash($plainPassword, PASSWORD_DEFAULT);
        }

        $jenisPelamar = $this->request->getPost('jenis_pelamar');
        $userData['id_role'] = $this->getRoleIdByJenisPelamar($jenisPelamar);

        $db->transStart();

        $userModel->update($id, $userData);


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
        if ($pelamar) {
            $statusPendaftaran = $this->request->getPost('status_pendaftaran');

            if (in_array($statusPendaftaran, self::STATUS_PENDAFTARAN, true)) {
                $now = date('Y-m-d H:i:s');
                $updatePelamarData = ['status_pendaftaran' => $statusPendaftaran];

                if ($statusPendaftaran === 'menunggu_aktivasi') {
                    $updatePelamarData['terdaftar_pada']  = null;
                    $updatePelamarData['diaktivasi_oleh'] = null;
                    $updatePelamarData['diaktivasi_pada'] = null;
                } elseif ($statusPendaftaran === 'terdaftar') {
                    $updatePelamarData['terdaftar_pada']  = $pelamar['terdaftar_pada'] ?? $now;
                    $updatePelamarData['diaktivasi_oleh'] = null;
                    $updatePelamarData['diaktivasi_pada'] = null;
                } elseif ($statusPendaftaran === 'aktif') {
                    $updatePelamarData['terdaftar_pada']  = $pelamar['terdaftar_pada'] ?? $now;
                    $updatePelamarData['diaktivasi_oleh'] = (int) session()->get('id');
                    $updatePelamarData['diaktivasi_pada'] = $now;
                }

                $pelamarModel->update($pelamar['id'], $updatePelamarData);
            }
        }
        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Data gagal diupdate');
        }

        if ($plainPassword !== '') {
            $this->sendAdminCreatedAccountEmail(
                $email,
                (string) $this->request->getPost('nama'),
                $plainPassword
            );
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

    private function sendAdminCreatedAccountEmail(string $userEmail, string $nama, string $plainPassword): void
    {
        $loginLink = site_url('login');

        $email = \Config\Services::email();
        $email->setTo($userEmail);
        $email->setSubject('Informasi Akun - BKK Tracer Study');
        $email->setMessage('
            <h3>Halo, ' . esc($nama) . '!</h3>
            <p>Akun BKK Tracer Study Anda telah dibuat oleh admin dan sudah terverifikasi.</p>
            <p>Silakan login menggunakan informasi berikut:</p>
            <table cellpadding="6" cellspacing="0" style="border-collapse:collapse;">
                <tr>
                    <td><strong>Email</strong></td>
                    <td>' . esc($userEmail) . '</td>
                </tr>
                <tr>
                    <td><strong>Password</strong></td>
                    <td>' . esc($plainPassword) . '</td>
                </tr>
            </table>
            <p>
                <a href="' . esc($loginLink, 'attr') . '"
                   style="background:#009ef7;color:#fff;padding:10px 20px;
                          border-radius:6px;text-decoration:none;">
                   Login Sekarang
                </a>
            </p>
            <p>Untuk keamanan akun, segera ubah password setelah berhasil login.</p>
            <p>Jika Anda merasa tidak terkait dengan pendaftaran ini, abaikan email ini.</p>
        ');
        $email->send();
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
