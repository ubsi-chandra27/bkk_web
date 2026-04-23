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

        // Update tb_users
        $userData = [
            'nama'      => $this->request->getPost('nama'),
            'email'     => $this->request->getPost('email'),
            'is_active' => $this->request->getPost('is_active'),
        ];
        if ($this->request->getPost('password')) {
            $userData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
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

        return redirect()->to('/admin/data-pelamar/profil/' . $id . '/edit')
            ->with('success', 'Profil berhasil diperbarui')
            ->with('active_tab', 'edit_profil');
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
}
