<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PelamarModel;
use App\Models\AlumniModel;
use App\Models\TracerModel;
use App\Models\BerkasModel;
use App\Models\BerkasLamaranModel;
use App\Models\AktivitasModel;
use App\Models\AngkatanModel;
use App\Models\JurusanModel;
use App\Models\JenisBerkasModel;
use App\Models\LamaranModel;
use App\Models\RiwayatKerjaModel;

class ProfilPelamarController extends BaseController
{
    private const STATUS_PENDAFTARAN = [
        'menunggu_aktivasi',
        'terdaftar',
        'aktif',
    ];

    protected $userModel;
    protected $pelamarModel;
    protected $alumniModel;
    protected $tracerModel;
    protected $berkasModel;
    protected $berkasLamaranModel;
    protected $aktivitasModel;
    protected $angkatanModel;
    protected $jurusanModel;
    protected $jenisBerkasModel;
    protected $lamaranModel;
    protected $riwayatKerjaModel;

    public function __construct()
    {
        $this->userModel   = new UserModel();
        $this->pelamarModel = new PelamarModel();
        $this->alumniModel = new AlumniModel();
        $this->tracerModel = new TracerModel();
        $this->berkasModel = new BerkasModel();
        $this->berkasLamaranModel = new BerkasLamaranModel();
        $this->aktivitasModel = new AktivitasModel();
        $this->angkatanModel = new AngkatanModel();
        $this->jurusanModel = new JurusanModel();
        $this->jenisBerkasModel = new JenisBerkasModel();
        $this->lamaranModel = new LamaranModel();
        $this->riwayatKerjaModel = new RiwayatKerjaModel();
    }

    public function show($id)
    {
        $user   = $this->userModel->find($id);
        $pelamar = $this->pelamarModel->getByUserId($id);

        if (!$user) {
            return redirect()->to('/admin/data-pelamar')->with('error', 'Data pelamar tidak ditemukan');
        }

        // Get alumni data if exists
        $alumni = null;
        if ($pelamar) {
            $alumni = $this->alumniModel->getByPelamar($pelamar['id']);
        }

        // Get tracer data if alumni exists
        $tracer = null;
        if ($alumni) {
            $tracer = $this->tracerModel->getByAlumni($alumni['id']);
        }

        // Get berkas data
        $berkas = [];
        if ($pelamar) {
            $berkasList = $this->berkasModel->getByPelamar($pelamar['id']);
            foreach ($berkasList as $b) {
                $berkas[$b['jenis_berkas']] = $b;
            }
        }
        $lamaran = $this->lamaranModel->getByPelamar($pelamar['id']);
        $selectedLamaran = null;
        $berkasLamaran = [];
        $selectedTab = (string) $this->request->getGet('tab');
        $selectedLamaranId = (int) $this->request->getGet('id_lamaran');

        if ($pelamar && $selectedLamaranId > 0) {
            $selectedLamaran = $this->lamaranModel
                ->select('tb_lamaran.*, tb_lowongan.posisi, tb_perusahaan.nama_perusahaan')
                ->join('tb_lowongan', 'tb_lowongan.id = tb_lamaran.id_lowongan', 'left')
                ->join('tb_perusahaan', 'tb_perusahaan.id = tb_lowongan.id_perusahaan', 'left')
                ->where('tb_lamaran.id', $selectedLamaranId)
                ->where('tb_lamaran.id_pelamar', $pelamar['id'])
                ->first();

            if ($selectedLamaran) {
                $berkasLamaran = $this->berkasLamaranModel->getByLamaran($selectedLamaranId);
                $selectedTab = 'tab_berkas';
            }
        }

        $data['user']   = $user;
        $data['pelamar'] = $pelamar;
        $data['alumni'] = $alumni;
        $data['tracer'] = $tracer;
        $data['berkas'] = $berkas;
        $data['berkasLamaran'] = $berkasLamaran;
        $data['selectedLamaran'] = $selectedLamaran;
        $data['lamaran'] = $lamaran;
        $data['jenisBerkas'] = $this->jenisBerkasModel->getAktif();

        $data['aktivator'] = !empty($pelamar['diaktivasi_oleh'])
            ? $this->userModel->find($pelamar['diaktivasi_oleh'])
            : null;
        $data['selectedTab'] = $selectedTab;

        return view('admin/data_pelamar/profil', $data);
    }

    public function edit($id)
    {
        $user   = $this->userModel->find($id);
        $pelamar = $this->pelamarModel->getByUserId($id);

        if (!$user) {
            return redirect()->to('/admin/data-pelamar')->with('error', 'Data pelamar tidak ditemukan');
        }

        // Get alumni data if exists
        $alumni = null;
        if ($pelamar) {
            $alumni = $this->alumniModel->getByPelamar($pelamar['id']);
        }

        // Get tracer data if alumni exists
        $tracer = null;
        if ($alumni) {
            $tracer = $this->tracerModel->getByAlumni($alumni['id']);
        }

        // Get berkas data
        $berkas = [];
        if ($pelamar) {
            $berkasList = $this->berkasModel->getByPelamar($pelamar['id']);
            foreach ($berkasList as $b) {
                $berkas[$b['jenis_berkas']] = $b;
            }
        }

        $data['user']   = $user;
        $data['pelamar'] = $pelamar;
        $data['alumni'] = $alumni;
        $data['tracer'] = $tracer;
        $data['berkas'] = $berkas;
        $data['jenisBerkas'] = $this->jenisBerkasModel->getAktif();
        $data['angkatan'] = $this->angkatanModel->findAll();
        $data['jurusan'] = $this->jurusanModel->findAll();
        $data['aktivitas'] = $this->aktivitasModel->findAll();

        return view('admin/data_pelamar/edit_profil', $data);
    }

    public function update($id)
    {
        $userModel   = new UserModel();
        $pelamarModel = new PelamarModel();

        $validationRules = [
            'nama'      => 'required|min_length[3]',
            'email'     => 'required|valid_email|is_unique[tb_users.email,id,' . $id . ']',
            'password'  => 'permit_empty|min_length[6]',
            'is_active' => 'required|in_list[0,1]',
            'is_verified' => 'required|in_list[0,1]',
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
                ->with('error', implode(' ', $this->validator->getErrors()))
                ->with('active_tab', 'edit_profil');
        }

        $email = strtolower(trim((string) $this->request->getPost('email')));
        $plainPassword = (string) $this->request->getPost('password');

        // Update tb_users
        $userData = [
            'nama'      => $this->request->getPost('nama'),
            'email'     => $email,
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

        if ($plainPassword !== '') {
            $userData['password'] = password_hash($plainPassword, PASSWORD_DEFAULT);
        }
        $userModel->update($id, $userData);

        // Update tb_pelamar
        $pelamarData = [
            'telepon'       => $this->request->getPost('telepon'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tempat_lahir'  => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'alamat'        => $this->request->getPost('alamat'),
            'nomer_nik'     => $this->request->getPost('nomer_nik'),
        ];

        $pelamarData = array_merge(
            $pelamarData,
            $this->buildStatusPendaftaranData(
                $this->request->getPost('status_pendaftaran'),
                $pelamarModel->getByUserId($id),
                (int) session()->get('id')
            )
        );

        // Handle upload foto
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move('uploads/foto/', $namaFile);
            $pelamarData['foto'] = $namaFile;
        }

        $existing = $pelamarModel->getByUserId($id);
        if ($existing) {
            $pelamarModel->where('id_user', $id)->set($pelamarData)->update();
        } else {
            $pelamarData['id_user'] = $id;
            $pelamarModel->insert($pelamarData);
        }

        if ($plainPassword !== '') {
            $this->sendAdminCreatedAccountEmail(
                $email,
                (string) $this->request->getPost('nama'),
                $plainPassword
            );
        }

        return redirect()->to('/admin/data-pelamar/profil/' . $id . '/edit')
            ->with('success', 'Profil berhasil diperbarui')
            ->with('active_tab', 'edit_profil');
    }

    private function sendAdminCreatedAccountEmail(string $userEmail, string $nama, string $plainPassword): void
    {
        $loginLink = site_url('login');

        $email = \Config\Services::email();
        $email->setTo($userEmail);
        $email->setSubject('Informasi Akun - BKK Tracer Study');
        $email->setMessage('
            <h3>Halo, ' . esc($nama) . '!</h3>
            <p>Akun BKK Tracer Study Anda telah dibuat atau diperbarui oleh admin dan sudah terverifikasi.</p>
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

    private function buildStatusPendaftaranData(?string $statusPendaftaran, ?array $pelamar = null, ?int $aktivatorId = null): array
    {
        $statusPendaftaran = strtolower((string) $statusPendaftaran);

        if (!in_array($statusPendaftaran, self::STATUS_PENDAFTARAN, true)) {
            return [];
        }

        $now = date('Y-m-d H:i:s');
        $data = [
            'status_pendaftaran' => $statusPendaftaran,
        ];

        if ($statusPendaftaran === 'menunggu_aktivasi') {
            $data['terdaftar_pada'] = null;
            $data['diaktivasi_oleh'] = null;
            $data['diaktivasi_pada'] = null;
        }

        if ($statusPendaftaran === 'terdaftar') {
            $data['terdaftar_pada'] = $pelamar['terdaftar_pada'] ?? $now;
            $data['diaktivasi_oleh'] = null;
            $data['diaktivasi_pada'] = null;
        }

        if ($statusPendaftaran === 'aktif') {
            $data['terdaftar_pada'] = $pelamar['terdaftar_pada'] ?? $now;
            $data['diaktivasi_oleh'] = $aktivatorId;
            $data['diaktivasi_pada'] = $now;
        }

        return $data;
    }

    public function updateTracer($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/data-pelamar')->with('error', 'Data pelamar tidak ditemukan');
        }

        $pelamar = $this->pelamarModel->getByUserId($id);
        if (!$pelamar) {
            return redirect()->to('/admin/data-pelamar/profil/' . $id)->with('error', 'Data pelamar tidak ditemukan');
        }

        // Update data alumni
        $alumniData = [
            'id_angkatan' => $this->request->getPost('id_angkatan') ?: null,
            'id_jurusan'  => $this->request->getPost('id_jurusan') ?: null,
            'nis'         => $this->request->getPost('nis'),
            'nisn'        => $this->request->getPost('nisn'),
            'no_ijazah'   => $this->request->getPost('no_ijazah'),
        ];

        $alumni = $this->alumniModel->getByPelamar($pelamar['id']);
        if ($alumni) {
            $this->alumniModel->update($alumni['id'], $alumniData);
            $alumniId = $alumni['id'];
        } else {
            $alumniData['id_pelamar'] = $pelamar['id'];
            $alumniId = $this->alumniModel->insert($alumniData, true);
        }

        // Get aktivitas slug untuk menentukan field mana yang disimpan
        $idAktivitas = $this->request->getPost('id_aktivitas');
        $aktivitas = $this->aktivitasModel->find($idAktivitas);
        $namaAktivitas = is_array($aktivitas) ? ($aktivitas['nama_aktivitas'] ?? '') : '';
        $slug = strtolower(str_replace(' ', '_', trim($namaAktivitas)));

        // Base tracer data
        $tracerData = [
            'id_alumni'    => $alumniId,
            'id_aktivitas' => $idAktivitas ?: null,
            // Reset semua field spesifik
            'posisi_kerja'         => null,
            'nama_dudi'            => null,
            'bidang_dudi'          => null,
            'alamat_dudi'          => null,
            'tahun_mulai_kerja'    => null,
            'is_relevan_jurusan'   => null,
            'penghasilan_range'    => null,
            'universitas'          => null,
            'program_studi'        => null,
            'status_kuliah'        => null,
            'nama_usaha'           => null,
            'bidang_usaha'         => null,
            'modal_awal'           => null,
            'penghasilan_usaha'    => null,
            'rencana_universitas'  => null,
            'rencana_prodi'        => null,
        ];

        // Set hanya field yang relevan berdasarkan aktivitas
        switch ($slug) {
            case 'bekerja':
                $tracerData['posisi_kerja']       = $this->request->getPost('posisi_kerja') ?: null;
                $tracerData['nama_dudi']          = $this->request->getPost('nama_dudi') ?: null;
                $tracerData['bidang_dudi']        = $this->request->getPost('bidang_dudi') ?: null;
                $tracerData['alamat_dudi']        = $this->request->getPost('alamat_dudi') ?: null;
                $tracerData['tahun_mulai_kerja']  = $this->request->getPost('tahun_mulai_kerja') ?: null;
                $tracerData['is_relevan_jurusan'] = $this->request->getPost('is_relevan_jurusan') !== null
                    ? $this->request->getPost('is_relevan_jurusan')
                    : null;
                $tracerData['penghasilan_range']  = $this->request->getPost('penghasilan_range') ?: null;
                break;

            case 'kuliah':
                $tracerData['universitas']   = $this->request->getPost('universitas') ?: null;
                $tracerData['program_studi'] = $this->request->getPost('program_studi') ?: null;
                $tracerData['status_kuliah'] = $this->request->getPost('status_kuliah') ?: null;
                break;

            case 'wirausaha':
                $tracerData['nama_usaha']        = $this->request->getPost('nama_usaha') ?: null;
                $tracerData['bidang_usaha']      = $this->request->getPost('bidang_usaha') ?: null;
                $tracerData['modal_awal']        = $this->request->getPost('modal_awal') ?: null;
                $tracerData['penghasilan_usaha'] = $this->request->getPost('penghasilan_usaha') ?: null;
                break;

            case 'berencana_kuliah':
                $tracerData['rencana_universitas'] = $this->request->getPost('rencana_universitas') ?: null;
                $tracerData['rencana_prodi']       = $this->request->getPost('rencana_prodi') ?: null;
                break;

            case 'mencari_kerja':
                // Tidak ada data tambahan untuk status mencari kerja
                break;
        }

        $tracer = $this->tracerModel->getByAlumni($alumniId);
        if ($tracer) {
            $this->tracerModel->update($tracer['id'], $tracerData);
        } else {
            $this->tracerModel->insert($tracerData);
        }

        return redirect()->to('/admin/data-pelamar/profil/' . $id . '/edit#edit_tracer')
            ->with('success', 'Data tracer alumni berhasil diperbarui')
            ->with('active_tab', 'edit_tracer');
    }

    public function uploadBerkas($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/data-pelamar')->with('error', 'Data pelamar tidak ditemukan');
        }

        $pelamar = $this->pelamarModel->getByUserId($id);
        if (!$pelamar) {
            return redirect()->to('/admin/data-pelamar/profil/' . $id)->with('error', 'Data pelamar tidak ditemukan');
        }

        $idJenisBerkas = (int) $this->request->getPost('id_jenis_berkas');
        $file = $this->request->getFile('berkas');

        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid');
        }

        $jenisBerkas = $this->jenisBerkasModel->find($idJenisBerkas);
        if (!$jenisBerkas) {
            return redirect()->back()->with('error', 'Jenis berkas tidak ditemukan');
        }

        $namaFile = $file->getRandomName();
        $file->move('uploads/berkas/', $namaFile);

        $existing = $this->berkasModel->getByPelamarAndJenis((int) $pelamar['id'], $idJenisBerkas);

        if ($existing) {
            if (!empty($existing['path_file']) && file_exists($existing['path_file'])) {
                unlink($existing['path_file']);
            }
            $this->berkasModel->update($existing['id'], [
                'nama_file' => $file->getClientName(),
                'path_file' => 'uploads/berkas/' . $namaFile,
                'status'    => 'sudah_diunggah',
            ]);
        } else {
            $this->berkasModel->insert([
                'id_pelamar'  => $pelamar['id'],
                'id_jenis_berkas' => $idJenisBerkas,
                'nama_file'   => $file->getClientName(),
                'path_file'   => 'uploads/berkas/' . $namaFile,
                'status'      => 'sudah_diunggah',
            ]);
        }

        return redirect()->to('/admin/data-pelamar/profil/' . $id . '/edit#edit_berkas')
            ->with('success', 'Berkas berhasil diunggah')
            ->with('active_tab', 'edit_berkas');
    }

    public function riwayatKerja($id)
    {
        if (strtolower($this->request->getMethod()) !== 'get') {
            return $this->riwayatKerjaJson(false, 'Method tidak diizinkan', [], 405);
        }

        $pelamar = $this->pelamarModel->getByUserId((int) $id);
        if (!$pelamar) {
            return $this->riwayatKerjaJson(false, 'Data pelamar tidak ditemukan', [], 404);
        }

        $data = $this->riwayatKerjaModel
            ->select('id, id_pelamar, nama_perusahaan, posisi_jabatan, tanggal_mulai, tanggal_selesai, is_masih_bekerja, deskripsi_kerja')
            ->where('id_pelamar', $pelamar['id'])
            ->orderBy('tanggal_mulai', 'DESC')
            ->orderBy('id', 'DESC')
            ->findAll();

        return $this->riwayatKerjaJson(true, 'Data riwayat kerja berhasil diambil', [
            'data' => $data,
        ]);
    }

    public function storeRiwayatKerja($id)
    {
        if (strtolower($this->request->getMethod()) !== 'post') {
            return $this->riwayatKerjaJson(false, 'Method tidak diizinkan', [], 405);
        }

        if (!$this->canManageRiwayatKerja()) {
            return $this->riwayatKerjaJson(false, 'Admin DUDI tidak memiliki akses untuk menambah riwayat kerja', [], 403);
        }

        $pelamar = $this->pelamarModel->getByUserId((int) $id);
        if (!$pelamar) {
            return $this->riwayatKerjaJson(false, 'Data pelamar tidak ditemukan', [], 404);
        }

        if (!$this->validate($this->riwayatKerjaValidationRules())) {
            return $this->riwayatKerjaJson(false, 'Validasi gagal', [
                'errors' => $this->validator->getErrors(),
            ], 422);
        }

        $this->riwayatKerjaModel->insert($this->buildRiwayatKerjaPayload((int) $pelamar['id']));

        return $this->riwayatKerjaJson(true, 'Riwayat kerja berhasil ditambahkan');
    }

    public function updateRiwayatKerja($id, int $idRiwayat)
    {
        if (strtolower($this->request->getMethod()) !== 'put') {
            return $this->riwayatKerjaJson(false, 'Method tidak diizinkan', [], 405);
        }

        if (!$this->canManageRiwayatKerja()) {
            return $this->riwayatKerjaJson(false, 'Admin DUDI tidak memiliki akses untuk mengedit riwayat kerja', [], 403);
        }

        $pelamar = $this->pelamarModel->getByUserId((int) $id);
        if (!$pelamar) {
            return $this->riwayatKerjaJson(false, 'Data pelamar tidak ditemukan', [], 404);
        }

        $riwayat = $this->riwayatKerjaModel
            ->where('id', $idRiwayat)
            ->where('id_pelamar', $pelamar['id'])
            ->first();

        if (!$riwayat) {
            return $this->riwayatKerjaJson(false, 'Riwayat kerja tidak ditemukan', [], 404);
        }

        if (!$this->validate($this->riwayatKerjaValidationRules())) {
            return $this->riwayatKerjaJson(false, 'Validasi gagal', [
                'errors' => $this->validator->getErrors(),
            ], 422);
        }

        $this->riwayatKerjaModel->update($idRiwayat, $this->buildRiwayatKerjaPayload((int) $pelamar['id']));

        return $this->riwayatKerjaJson(true, 'Riwayat kerja berhasil diperbarui');
    }

    public function destroyRiwayatKerja($id, int $idRiwayat)
    {
        if (strtolower($this->request->getMethod()) !== 'delete') {
            return $this->riwayatKerjaJson(false, 'Method tidak diizinkan', [], 405);
        }

        if (!$this->canManageRiwayatKerja()) {
            return $this->riwayatKerjaJson(false, 'Admin DUDI tidak memiliki akses untuk menghapus riwayat kerja', [], 403);
        }

        $pelamar = $this->pelamarModel->getByUserId((int) $id);
        if (!$pelamar) {
            return $this->riwayatKerjaJson(false, 'Data pelamar tidak ditemukan', [], 404);
        }

        $riwayat = $this->riwayatKerjaModel
            ->where('id', $idRiwayat)
            ->where('id_pelamar', $pelamar['id'])
            ->first();

        if (!$riwayat) {
            return $this->riwayatKerjaJson(false, 'Riwayat kerja tidak ditemukan', [], 404);
        }

        $this->riwayatKerjaModel->delete($idRiwayat);

        return $this->riwayatKerjaJson(true, 'Riwayat kerja berhasil dihapus');
    }

    private function riwayatKerjaValidationRules(): array
    {
        return [
            'nama_perusahaan' => [
                'label' => 'Nama perusahaan',
                'rules' => 'required|min_length[2]|max_length[150]',
            ],
            'posisi_jabatan' => [
                'label' => 'Posisi jabatan',
                'rules' => 'required|min_length[2]|max_length[100]',
            ],
            'tanggal_mulai' => [
                'label' => 'Tanggal mulai',
                'rules' => 'required|valid_date[Y-m-d]',
            ],
            'tanggal_selesai' => [
                'label' => 'Tanggal selesai',
                'rules' => 'permit_empty|valid_date[Y-m-d]',
            ],
            'deskripsi_kerja' => [
                'label' => 'Deskripsi kerja',
                'rules' => 'permit_empty|max_length[2000]',
            ],
        ];
    }

    private function canManageRiwayatKerja(): bool
    {
        return (int) session()->get('id_role') !== 3;
    }

    private function buildRiwayatKerjaPayload(int $idPelamar): array
    {
        $isMasihBekerja = in_array($this->riwayatKerjaInput('is_masih_bekerja'), ['1', 'on'], true);

        return [
            'id_pelamar' => $idPelamar,
            'nama_perusahaan' => trim((string) $this->riwayatKerjaInput('nama_perusahaan')),
            'posisi_jabatan' => trim((string) $this->riwayatKerjaInput('posisi_jabatan')),
            'tanggal_mulai' => $this->riwayatKerjaInput('tanggal_mulai'),
            'tanggal_selesai' => $isMasihBekerja ? null : ($this->riwayatKerjaInput('tanggal_selesai') ?: null),
            'is_masih_bekerja' => $isMasihBekerja ? 1 : 0,
            'deskripsi_kerja' => trim((string) $this->riwayatKerjaInput('deskripsi_kerja')),
        ];
    }

    private function riwayatKerjaInput(string $key): ?string
    {
        $value = $this->request->getVar($key);
        if ($value !== null) {
            return is_array($value) ? null : (string) $value;
        }

        $rawInput = $this->request->getRawInput();
        if (array_key_exists($key, $rawInput)) {
            return is_array($rawInput[$key]) ? null : (string) $rawInput[$key];
        }

        return null;
    }

    private function riwayatKerjaJson(bool $success, string $message, array $extra = [], int $statusCode = 200)
    {
        return $this->response
            ->setStatusCode($statusCode)
            ->setJSON(array_merge([
                'success' => $success,
                'message' => $message,
                'csrfHash' => csrf_hash(),
            ], $extra));
    }
}
