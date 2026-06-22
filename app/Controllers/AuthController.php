<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PelamarModel;
use App\Models\AdminModel;
use App\Models\AlumniModel;
use App\Models\TracerModel;
use App\Models\JurusanModel;
use App\Models\AngkatanModel;

class AuthController extends BaseController
{
    public function loginForm()
    {
        return view('auth/login');
    }

    public function login()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel    = new UserModel();
        $pelamarModel = new PelamarModel();
        $adminModel   = new AdminModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }

        if ($user['is_active'] != 1) {
            return redirect()->back()->withInput()->with('error', 'Akun Anda belum aktif.');
        }

        if ((int) ($user['is_verified'] ?? 0) === 0) {
            return redirect()->back()->withInput()->with('error', 'Akun belum diverifikasi. Silakan cek email Anda.');
        }

        $foto = null;
        $role = (int) $user['id_role'];

        if (in_array($role, [1, 2, 3])) {
            $admin = $adminModel->where('id_user', $user['id'])->first();
            $foto  = $admin['foto'] ?? null;
        } elseif (in_array($role, [4, 5])) {
            $pelamar = $pelamarModel->where('id_user', $user['id'])->first();
            $foto    = $pelamar['foto'] ?? null;
        }

        session()->set([
            'isLoggedIn' => true,
            'id'   => $user['id'],
            'nama'      => $user['nama'],
            'email'     => $user['email'],
            'id_role'   => $user['id_role'],
            'foto'      => $foto,
        ]);

        $userModel->update($user['id'], [
            'last_login' => date('Y-m-d H:i:s'),
        ]);

        $role = (int) $user['id_role'];
        return redirect()->to('/dashboard');

        return redirect()->to('/');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function registerForm()
    {
        $jurusanModel = new JurusanModel();
        $angkatanModel = new AngkatanModel();

        return view('auth/register', [
            'jurusans' => $jurusanModel->where('is_active', 1)->orderBy('kompetensi_keahlian', 'ASC')->findAll(),
            'angkatans' => $angkatanModel->where('is_active', 1)->orderBy('tahun', 'DESC')->findAll(),
        ]);
    }

    public function register()
    {
        $rules = [
            'nama'                   => 'required|min_length[3]',
            'email'                  => 'required|valid_email|is_unique[tb_users.email]',
            'password'               => 'required|min_length[8]|strong_password',
            'password_confirmation'  => 'required|matches[password]',
            'role'                   => 'required|in_list[pelamar_alumni,pelamar_umum]',
            'terms'                  => 'required',
        ];
        $messages = [
            'email' => [
                'is_unique' => 'Email sudah terdaftar. Gunakan email lain.',
            ],
            'role' => [
                'in_list' => 'Jenis akun tidak valid.',
            ],
            'password' => [
                'strong_password' => 'Password harus minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan karakter simbol.',
            ],
        ];

        if ($this->request->getPost('role') === 'pelamar_alumni') {
            $rules = array_merge($rules, [
                'id_jurusan'  => 'required|integer|is_not_unique[tb_jurusan.id]',
                'id_angkatan' => 'required|integer|is_not_unique[tb_angkatan.id]',
                'nis'         => 'required|max_length[50]',
                'nisn'        => 'required|max_length[50]',
                'no_ijazah'   => 'required|max_length[100]',
            ]);
            $messages = array_merge($messages, [
                'id_jurusan' => [
                    'required' => 'Jurusan wajib dipilih untuk pelamar alumni.',
                    'is_not_unique' => 'Jurusan tidak valid.',
                ],
                'id_angkatan' => [
                    'required' => 'Angkatan wajib dipilih untuk pelamar alumni.',
                    'is_not_unique' => 'Angkatan tidak valid.',
                ],
                'nis' => [
                    'required' => 'NIS wajib diisi untuk pelamar alumni.',
                ],
                'nisn' => [
                    'required' => 'NISN wajib diisi untuk pelamar alumni.',
                ],
                'no_ijazah' => [
                    'required' => 'No ijazah wajib diisi untuk pelamar alumni.',
                ],
            ]);
        }

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        $email = strtolower(trim((string) $this->request->getPost('email')));
        $role = $this->request->getPost('role');
        $idRole = match ($role) {
            'pelamar_alumni' => 4,
            'pelamar_umum'   => 5,
            default         => 5,
        };
        $jenisPelamar = $role === 'pelamar_alumni' ? 'alumni' : 'umum';

        $userModel = new UserModel();
        $pelamarModel = new PelamarModel();
        $alumniModel = new AlumniModel();
        $tracerModel = new TracerModel();
        $db = \Config\Database::connect();
        $token = bin2hex(random_bytes(32));

        if ($userModel->where('email', $email)->first()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email sudah terdaftar. Gunakan email lain.');
        }

        $db->transStart();

        $userId = $userModel->insert([
            'id_role'   => $idRole,
            'nama'      => $this->request->getPost('nama'),
            'email'     => $email,
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'is_active' => 1,
            'email_token' => $token,
            'is_verified' => 0,
        ], true);

        $pelamarId = $pelamarModel->insert([
            'id_user'              => $userId,
            'jenis_pelamar'        => $jenisPelamar,
            'status_pendaftaran'   => 'menunggu_aktivasi',
        ], true);

        if ($role === 'pelamar_alumni') {
            $alumniId = $alumniModel->insert([
                'id_pelamar'   => $pelamarId,
                'id_jurusan'   => $this->request->getPost('id_jurusan'),
                'id_angkatan'  => $this->request->getPost('id_angkatan'),
                'nis'          => $this->request->getPost('nis'),
                'nisn'         => $this->request->getPost('nisn'),
                'no_ijazah'    => $this->request->getPost('no_ijazah'),
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
                ->with('error', 'Registrasi gagal. Silakan coba lagi.');
        }

        $notif = new \App\Libraries\NotificationService();
        $notif->notifyAdminsNewUser([
            'id'   => $userId,
            'nama' => $this->request->getPost('nama'),
        ], $jenisPelamar);

        $this->sendVerificationEmail(
            $email,
            (string) $this->request->getPost('nama'),
            base_url('verify-email/' . $token)
        );

        return redirect()->to('/login')
            ->with('success', 'Registrasi berhasil! Silakan cek email Anda untuk verifikasi akun.');
    }

    public function verifyEmail($token)
    {
        if (!preg_match('/^[a-f0-9]{64}$/', (string) $token)) {
            return redirect()->to('/login')
                ->with('error', 'Link verifikasi tidak valid atau sudah digunakan.');
        }

        $userModel = new UserModel();
        $user = $userModel
            ->where('email_token', $token)
            ->where('is_verified', 0)
            ->first();

        if (!$user) {
            return redirect()->to('/login')
                ->with('error', 'Link verifikasi tidak valid atau sudah digunakan.');
        }

        $userModel->update($user['id'], [
            'is_verified'       => 1,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'email_token'       => null,
        ]);

        return redirect()->to('/login')
            ->with('success', 'Email berhasil diverifikasi! Silakan login.');
    }

    public function forgotPassword()
    {
        return view('auth/forgot_password');
    }

    public function processForgotPassword()
    {
        $rules = [
            'email' => 'required|valid_email',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->back()->withInput();
        }

        $emailAddress = strtolower(trim((string) $this->request->getPost('email')));
        $successMessage = 'Jika email terdaftar, link reset password telah dikirim.';

        $userModel = new UserModel();
        $user = $userModel->where('email', $emailAddress)->first();

        if ($user) {
            $token = bin2hex(random_bytes(32));
            $resetLink = base_url('reset-password/' . $token);

            $userModel->update($user['id'], [
                'reset_token'   => $token,
                'reset_expires' => date('Y-m-d H:i:s', strtotime('+1 hour')),
            ]);

            $email = \Config\Services::email();
            $email->setTo($emailAddress);
            $email->setSubject('Reset Password - BKK Tracer Study');
            $email->setMessage('<p>Klik link berikut untuk reset password (berlaku 1 jam):<br><a href="' . $resetLink . '">' . $resetLink . '</a></p>');
            $email->send();
        }

        session()->setFlashdata('success', $successMessage);
        return redirect()->to('/forgot-password');
    }

    public function resetPassword($token)
    {
        $user = $this->findValidResetToken($token);

        if (!$user) {
            session()->setFlashdata('error', 'Link reset password tidak valid atau sudah kedaluwarsa.');
            return redirect()->to('/forgot-password');
        }

        return view('auth/reset_password', [
            'token' => $token,
        ]);
    }

    public function processResetPassword($token)
    {
        $rules = [
            'password'         => 'required|min_length[8]|strong_password',
            'confirm_password' => 'required|matches[password]',
        ];
        $messages = [
            'password' => [
                'strong_password' => 'Password harus minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan karakter simbol.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        $user = $this->findValidResetToken($token);

        if (!$user) {
            session()->setFlashdata('error', 'Link reset password tidak valid atau sudah kedaluwarsa.');
            return redirect()->to('/forgot-password');
        }

        $userModel = new UserModel();
        $userModel->update($user['id'], [
            'password'      => password_hash((string) $this->request->getPost('password'), PASSWORD_BCRYPT),
            'reset_token'   => null,
            'reset_expires' => null,
        ]);

        session()->setFlashdata('success', 'Password berhasil diperbarui. Silakan login dengan password baru.');
        return redirect()->to('/login');
    }

    private function findValidResetToken(string $token): ?array
    {
        if (!preg_match('/^[a-f0-9]{64}$/', $token)) {
            return null;
        }

        $userModel = new UserModel();

        return $userModel
            ->where('reset_token', $token)
            ->where('reset_expires >=', date('Y-m-d H:i:s'))
            ->first();
    }

    private function sendVerificationEmail(string $userEmail, string $nama, string $verifyLink): void
    {
        $email = \Config\Services::email();
        $email->setTo($userEmail);
        $email->setSubject('Verifikasi Email - BKK Tracer Study');
        $email->setMessage('
            <h3>Halo, ' . esc($nama) . '!</h3>
            <p>Terima kasih telah mendaftar. Klik tombol berikut untuk verifikasi email Anda:</p>
            <a href="' . esc($verifyLink, 'attr') . '"
               style="background:#009ef7;color:#fff;padding:10px 20px;
                      border-radius:6px;text-decoration:none;">
               Verifikasi Email
            </a>
            <p>Link berlaku selama 24 jam.</p>
            <p>Jika Anda tidak merasa mendaftar, abaikan email ini.</p>
        ');
        $email->send();
    }
}
