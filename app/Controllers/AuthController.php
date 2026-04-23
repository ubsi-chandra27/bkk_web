<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PelamarModel;
use App\Models\AdminModel;
use App\Models\AlumniModel;
use App\Models\TracerModel;

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

        if (in_array($role, [1, 2])) {
            return redirect()->to('/dashboard');
        }

        return redirect()->to('/');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function registerForm()
    {
        return view('auth/register');
    }

    public function register()
    {
        $rules = [
            'nama'                   => 'required|min_length[3]',
            'email'                  => 'required|valid_email|is_unique[tb_users.email]',
            'password'               => 'required|min_length[6]',
            'password_confirmation'  => 'required|matches[password]',
            'role'                   => 'required',
            'terms'                  => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

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

        $db->transStart();

        $userId = $userModel->insert([
            'id_role'   => $idRole,
            'nama'      => $this->request->getPost('nama'),
            'email'     => $this->request->getPost('email'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'is_active' => 1,
        ], true);

        $pelamarId = $pelamarModel->insert([
            'id_user'        => $userId,
            'jenis_pelamar'  => $jenisPelamar,
        ], true);

        if ($role === 'pelamar_alumni') {
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
                ->with('error', 'Registrasi gagal. Silakan coba lagi.');
        }

        return redirect()->to('/login')->with('success', 'Registrasi berhasil. Silakan login.');
    }
}
