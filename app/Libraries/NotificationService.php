<?php

namespace App\Libraries;

use App\Models\NotificationModel;
use App\Models\UserModel;
use App\Models\LowonganModel;
use App\Models\PerusahaanModel;

class NotificationService
{
    protected $notificationModel;
    protected $userModel;
    protected $lowonganModel;
    protected $perusahaanModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
        $this->userModel         = new UserModel();
        $this->lowonganModel     = new LowonganModel();
        $this->perusahaanModel   = new PerusahaanModel();
    }

    public function notifyAdminsNewApplication(array $lamaran, array $pelamar): void
    {
        $namaPelamar   = $pelamar['nama'] ?? 'Pelamar';
        $idLowongan    = $lamaran['id_lowongan'];
        $lowongan      = $this->lowonganModel->find($idLowongan);
        $namaLowongan  = $lowongan['posisi'] ?? 'Posisi tidak diketahui';

        // Ambil id_user dari pelamar
        $idUserPelamar = $pelamar['id_user'] ?? $pelamar['id'] ?? null;

        $notifData = [
            'sender_id' => $idUserPelamar,
            'type'      => 'new_application',
            'title'     => 'Lamaran Baru',
            'message'   => $namaPelamar . ' - ' . $namaLowongan,
            'url'       => '/admin/data-lamaran/',
        ];

        // A. Super admin dan admin_bkk
        $admins = $this->userModel
            ->where('id_role', 1) // super_admin
            ->orWhere('id_role', 2) // admin_bkk
            ->findAll();

        if (!empty($admins)) {
            $this->notificationModel->sendBulk($admins, $notifData);
        }

        // B. Admin DUDI (hanya pemilik perusahaan yang sesuai dengan lowongan)
        if ($lowongan && isset($lowongan['id_perusahaan'])) {
            $perusahaan = $this->perusahaanModel
                ->where('id', $lowongan['id_perusahaan'])
                ->first();

            if ($perusahaan && isset($perusahaan['id_user'])) {
                $this->notificationModel->sendOne($perusahaan['id_user'], $notifData);
            }
        }
    }

    public function notifyApplicantStatusChanged(array $lamaran, string $newStatus): void
    {
        $statusLabels = [
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'menunggu_diverifikasi' => 'Menunggu Verifikasi',
            'diproses'            => 'Diproses',
            'lolos_verifikasi'    => 'Lolos Verifikasi',
            'wawancara'           => 'Wawancara',
            'tidak_lolos'         => 'Tidak Lolos',
            'diterima'            => 'Diterima',
            'ditolak'             => 'Ditolak',
        ];

        $labelStatus = $statusLabels[$newStatus] ?? ucfirst(str_replace('_', ' ', $newStatus));

        $idLowongan   = $lamaran['id_lowongan'];
        $lowongan     = $this->lowonganModel->find($idLowongan);
        $namaLowongan = $lowongan['posisi'] ?? 'Posisi tidak diketahui';

        $pelamar = null;
        if (isset($lamaran['id_pelamar'])) {
            $pelamarModel = new \App\Models\PelamarModel();
            $pelamarData  = $pelamarModel->find($lamaran['id_pelamar']);
            if ($pelamarData) {
                $pelamarUser = $this->userModel->find($pelamarData['id_user']);
                if ($pelamarUser) {
                    $pelamar = ['id' => $pelamarUser['id']];
                }
            }
        }

        if (!$pelamar) {
            return;
        }

        $notifData = [
            'sender_id' => session()->get('id') ?? null,
            'type'      => 'status_changed',
            'title'     => 'Status Lamaran Diperbarui',
            'message'   => $namaLowongan . ' - ' . $labelStatus,
            'url'       => '/profil#tab_lamaran',
        ];

        $this->notificationModel->sendOne($pelamar['id'], $notifData);
    }

    public function notifyAdminsNewUser(array $user, string $userType): void
    {
        $namaUser = $user['nama'] ?? 'Pengguna';
        $userId   = $user['id'] ?? $user['id_user'] ?? null;
        $label    = strtolower($userType) === 'alumni' ? 'Pelamar Alumni' : 'Pelamar Umum';

        $notifData = [
            'sender_id' => $userId,
            'type'      => 'new_user',
            'title'     => 'Pendaftar Baru',
            'message'   => $namaUser . ' mendaftar sebagai ' . $label,
            'url'       => '/admin/data-pelamar',
        ];

        $admins = $this->userModel
            ->where('id_role', 1)
            ->orWhere('id_role', 2)
            ->findAll();

        if (!empty($admins)) {
            $this->notificationModel->sendBulk($admins, $notifData);
        }
    }

    public function notifyAdminsTracerStudy(array $alumni): void
    {
        $namaAlumni  = $alumni['nama'] ?? $alumni['nama_alumni'] ?? 'Alumni';
        $idUserAlumni = $alumni['id_user'] ?? null;

        if (!$idUserAlumni && isset($alumni['id_pelamar'])) {
            $pelamarModel = new \App\Models\PelamarModel();
            $pelamar = $pelamarModel->find($alumni['id_pelamar']);
            $idUserAlumni = $pelamar['id_user'] ?? null;
        }

        $notifData = [
            'sender_id' => $idUserAlumni,
            'type'      => 'tracer_study_submitted',
            'title'     => 'Tracer Study Baru',
            'message'   => $namaAlumni . ' telah mengisi data tracer study',
            'url'       => '/admin/data-tracer',
        ];

        $admins = $this->userModel
            ->where('id_role', 1)
            ->orWhere('id_role', 2)
            ->findAll();

        if (!empty($admins)) {
            $this->notificationModel->sendBulk($admins, $notifData);
        }
    }
}
