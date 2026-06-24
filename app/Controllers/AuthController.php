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
    private const GOOGLE_AUTH_ENDPOINT = 'https://accounts.google.com/o/oauth2/v2/auth';
    private const GOOGLE_TOKEN_ENDPOINT = 'https://oauth2.googleapis.com/token';
    private const GOOGLE_TOKENINFO_ENDPOINT = 'https://oauth2.googleapis.com/tokeninfo';

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
            if ($user && in_array((string) ($user['auth_provider'] ?? 'local'), ['google', 'local_google'], true)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Akun ini terhubung dengan Google. Gunakan tombol Masuk dengan Google atau reset password.');
            }

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

        $this->startUserSession($user, $foto);

        $userModel->update($user['id'], [
            'last_login' => date('Y-m-d H:i:s'),
        ]);

        return $this->redirectAfterLogin((int) $user['id_role']);
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

    public function redirectToGoogle()
    {
        $google = config('GoogleAuth');

        if (! $google->isConfigured()) {
            return redirect()->to('/login')
                ->with('error', 'Login Google belum dikonfigurasi. Hubungi administrator.');
        }

        $state = bin2hex(random_bytes(32));
        $nonce = bin2hex(random_bytes(32));
        $codeVerifier = $this->base64UrlEncode(random_bytes(64));
        $codeChallenge = $this->base64UrlEncode(hash('sha256', $codeVerifier, true));

        session()->set([
            'google_oauth_state' => $state,
            'google_oauth_nonce' => $nonce,
            'google_oauth_code_verifier' => $codeVerifier,
            'google_oauth_started_at' => time(),
        ]);

        $params = [
            'client_id' => $google->clientId,
            'redirect_uri' => $google->getRedirectUri(),
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'nonce' => $nonce,
            'code_challenge' => $codeChallenge,
            'code_challenge_method' => 'S256',
            'access_type' => 'online',
            'prompt' => 'select_account',
        ];

        if ($google->hostedDomain !== '') {
            $params['hd'] = $google->hostedDomain;
        }

        return redirect()->to(self::GOOGLE_AUTH_ENDPOINT . '?' . http_build_query($params, '', '&', PHP_QUERY_RFC3986));
    }

    public function handleGoogleCallback()
    {
        $google = config('GoogleAuth');

        if (! $google->isConfigured()) {
            $this->clearGoogleOAuthSession();

            return redirect()->to('/login')
                ->with('error', 'Login Google belum dikonfigurasi. Hubungi administrator.');
        }

        if ($this->request->getGet('error')) {
            $this->clearGoogleOAuthSession();

            return redirect()->to('/login')
                ->with('error', 'Login Google dibatalkan atau tidak diizinkan.');
        }

        $state = (string) $this->request->getGet('state');
        $storedState = (string) session()->get('google_oauth_state');
        $nonce = (string) session()->get('google_oauth_nonce');
        $codeVerifier = (string) session()->get('google_oauth_code_verifier');
        $startedAt = (int) session()->get('google_oauth_started_at');

        if (
            $state === ''
            || $storedState === ''
            || ! hash_equals($storedState, $state)
            || $nonce === ''
            || $codeVerifier === ''
            || $startedAt < (time() - 600)
        ) {
            $this->clearGoogleOAuthSession();

            return redirect()->to('/login')
                ->with('error', 'Sesi login Google tidak valid atau sudah kedaluwarsa. Silakan coba lagi.');
        }

        $code = (string) $this->request->getGet('code');
        $this->clearGoogleOAuthSession();

        if ($code === '') {
            return redirect()->to('/login')
                ->with('error', 'Kode otorisasi Google tidak ditemukan. Silakan coba lagi.');
        }

        $tokenData = $this->exchangeGoogleCode($google, $code, $codeVerifier);
        if (! $tokenData || empty($tokenData['id_token'])) {
            return redirect()->to('/login')
                ->with('error', 'Gagal memverifikasi login Google. Silakan coba lagi.');
        }

        $profile = $this->verifyGoogleIdToken($google, (string) $tokenData['id_token'], $nonce);
        if (! $profile) {
            return redirect()->to('/login')
                ->with('error', 'Token Google tidak valid. Silakan coba lagi.');
        }

        $result = $this->findOrCreateGoogleUser($profile);
        if (! empty($result['error'])) {
            return redirect()->to('/login')->with('error', $result['error']);
        }

        $user = $result['user'] ?? null;
        if (! $user) {
            return redirect()->to('/login')
                ->with('error', 'Akun Google belum dapat diproses. Silakan coba lagi.');
        }

        if ((int) ($user['is_active'] ?? 0) !== 1) {
            return redirect()->to('/login')->with('error', 'Akun Anda belum aktif.');
        }

        if ((int) ($user['is_verified'] ?? 0) === 0) {
            return redirect()->to('/login')->with('error', 'Akun belum diverifikasi.');
        }

        $foto = null;
        $role = (int) $user['id_role'];

        if (in_array($role, [1, 2, 3], true)) {
            $admin = (new AdminModel())->where('id_user', $user['id'])->first();
            $foto = $admin['foto'] ?? null;
        } elseif (in_array($role, [4, 5], true)) {
            $pelamar = (new PelamarModel())->where('id_user', $user['id'])->first();
            $foto = $pelamar['foto'] ?? null;
        }

        $this->startUserSession($user, $foto);

        (new UserModel())->update($user['id'], [
            'last_login' => date('Y-m-d H:i:s'),
        ]);

        $message = ! empty($result['created'])
            ? 'Pendaftaran Google berhasil. Akun Anda menunggu aktivasi admin.'
            : 'Berhasil masuk dengan Google.';

        return $this->redirectAfterLogin($role)->with('success', $message);
    }

    private function exchangeGoogleCode($google, string $code, string $codeVerifier): ?array
    {
        try {
            $response = \Config\Services::curlrequest()->post(self::GOOGLE_TOKEN_ENDPOINT, [
                'form_params' => [
                    'code' => $code,
                    'client_id' => $google->clientId,
                    'client_secret' => $google->clientSecret,
                    'redirect_uri' => $google->getRedirectUri(),
                    'grant_type' => 'authorization_code',
                    'code_verifier' => $codeVerifier,
                ],
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'http_errors' => false,
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Google OAuth token exchange error: ' . $e->getMessage());

            return null;
        }

        if ($response->getStatusCode() !== 200) {
            log_message('error', 'Google OAuth token exchange failed with status ' . $response->getStatusCode());

            return null;
        }

        $data = json_decode((string) $response->getBody(), true);

        return is_array($data) ? $data : null;
    }

    private function verifyGoogleIdToken($google, string $idToken, string $nonce): ?array
    {
        try {
            $response = \Config\Services::curlrequest()->get(self::GOOGLE_TOKENINFO_ENDPOINT, [
                'query' => ['id_token' => $idToken],
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'http_errors' => false,
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Google OAuth token verification error: ' . $e->getMessage());

            return null;
        }

        if ($response->getStatusCode() !== 200) {
            log_message('error', 'Google OAuth token verification failed with status ' . $response->getStatusCode());

            return null;
        }

        $payload = json_decode((string) $response->getBody(), true);
        if (! is_array($payload)) {
            return null;
        }

        $issuer = (string) ($payload['iss'] ?? '');
        $email = strtolower(trim((string) ($payload['email'] ?? '')));
        $emailVerified = filter_var($payload['email_verified'] ?? false, FILTER_VALIDATE_BOOLEAN);

        if (($payload['aud'] ?? '') !== $google->clientId) {
            return null;
        }

        if (! in_array($issuer, ['accounts.google.com', 'https://accounts.google.com'], true)) {
            return null;
        }

        if ((int) ($payload['exp'] ?? 0) < time()) {
            return null;
        }

        if (($payload['nonce'] ?? '') !== $nonce) {
            return null;
        }

        if (! $emailVerified || ! filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
            return null;
        }

        if ($google->hostedDomain !== '' && strtolower((string) ($payload['hd'] ?? '')) !== $google->hostedDomain) {
            return null;
        }

        return [
            'sub' => (string) ($payload['sub'] ?? ''),
            'email' => $email,
            'name' => $this->limitText(trim((string) ($payload['name'] ?? '')), 100),
            'picture' => $this->limitText(trim((string) ($payload['picture'] ?? '')), 255),
        ];
    }

    private function findOrCreateGoogleUser(array $profile): array
    {
        $sub = trim((string) ($profile['sub'] ?? ''));
        $email = strtolower(trim((string) ($profile['email'] ?? '')));

        if ($sub === '' || $email === '') {
            return ['error' => 'Profil Google tidak lengkap. Silakan coba lagi.'];
        }

        $userModel = new UserModel();
        $pelamarModel = new PelamarModel();

        $existingByGoogle = $userModel->where('google_sub', $sub)->first();
        if ($existingByGoogle) {
            $userModel->update($existingByGoogle['id'], [
                'google_picture' => $profile['picture'] ?: null,
            ]);

            return [
                'user' => $userModel->find($existingByGoogle['id']),
                'created' => false,
            ];
        }

        $existingByEmail = $userModel->where('email', $email)->first();
        if ($existingByEmail) {
            $role = (int) ($existingByEmail['id_role'] ?? 0);

            if (in_array($role, [1, 2, 3], true)) {
                return [
                    'error' => 'Akun admin belum ditautkan dengan Google. Login admin tetap gunakan email dan password.',
                ];
            }

            $updates = [
                'google_sub' => $sub,
                'google_picture' => $profile['picture'] ?: null,
                'is_verified' => 1,
                'email_verified_at' => $existingByEmail['email_verified_at'] ?? date('Y-m-d H:i:s'),
                'email_token' => null,
            ];

            if (($existingByEmail['auth_provider'] ?? 'local') === 'local') {
                $updates['auth_provider'] = 'local_google';
            }

            $userModel->update($existingByEmail['id'], $updates);

            return [
                'user' => $userModel->find($existingByEmail['id']),
                'created' => false,
            ];
        }

        $db = \Config\Database::connect();
        $name = $profile['name'] ?: $this->limitText(strstr($email, '@', true) ?: 'Pelamar Google', 100);

        $db->transStart();

        $userId = $userModel->insert([
            'id_role' => 5,
            'nama' => $name,
            'email' => $email,
            'password' => password_hash(bin2hex(random_bytes(32)), PASSWORD_DEFAULT),
            'auth_provider' => 'google',
            'google_sub' => $sub,
            'google_picture' => $profile['picture'] ?: null,
            'is_active' => 1,
            'is_verified' => 1,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'email_token' => null,
        ], true);

        $pelamarModel->insert([
            'id_user' => $userId,
            'jenis_pelamar' => 'umum',
            'status_pendaftaran' => 'menunggu_aktivasi',
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return ['error' => 'Pendaftaran Google gagal disimpan. Silakan coba lagi.'];
        }

        try {
            $notif = new \App\Libraries\NotificationService();
            $notif->notifyAdminsNewUser([
                'id' => $userId,
                'nama' => $name,
            ], 'umum');
        } catch (\Throwable $e) {
            log_message('error', 'Google registration notification error: ' . $e->getMessage());
        }

        return [
            'user' => $userModel->find($userId),
            'created' => true,
        ];
    }

    private function clearGoogleOAuthSession(): void
    {
        session()->remove([
            'google_oauth_state',
            'google_oauth_nonce',
            'google_oauth_code_verifier',
            'google_oauth_started_at',
        ]);
    }

    private function startUserSession(array $user, ?string $foto = null): void
    {
        session()->regenerate(true);

        session()->set([
            'isLoggedIn' => true,
            'id' => $user['id'],
            'nama' => $user['nama'],
            'email' => $user['email'],
            'id_role' => $user['id_role'],
            'foto' => $foto,
        ]);
    }

    private function redirectAfterLogin(int $role)
    {
        if (in_array($role, [1, 2, 3], true)) {
            return redirect()->to('/dashboard');
        }

        if (in_array($role, [4, 5], true)) {
            return redirect()->to('/profil');
        }

        return redirect()->to('/');
    }

    private function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }

    private function limitText(string $value, int $length): string
    {
        if (function_exists('mb_substr')) {
            return mb_substr($value, 0, $length);
        }

        return substr($value, 0, $length);
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
