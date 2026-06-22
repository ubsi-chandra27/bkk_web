<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PelamarModel;
use App\Models\BerkasModel;
use App\Models\LamaranModel;
use App\Models\TracerModel;
use App\Models\AlumniModel;
use App\Models\AngkatanModel;
use App\Models\JurusanModel;
use App\Models\AktivitasModel;
use App\Models\JenisBerkasModel;
use App\Models\SyaratBerkasModel;
use App\Models\RiwayatKerjaModel;

class ProfilController extends BaseController
{
    private const STATUS_PENDAFTARAN = [
        'menunggu_aktivasi',
        'terdaftar',
        'aktif',
    ];

    protected $userModel;
    protected $pelamarModel;
    protected $berkasModel;
    protected $lamaranModel;
    protected $tracerModel;
    protected $alumniModel;
    protected $angkatanModel;
    protected $jurusanModel;
    protected $aktivitasModel;
    protected $jenisBerkasModel;
    protected $syaratBerkasModel;
    protected $riwayatKerjaModel;

    public function __construct()
    {
        helper('landing');
        $this->userModel   = new UserModel();
        $this->pelamarModel = new PelamarModel();
        $this->berkasModel  = new BerkasModel();
        $this->lamaranModel = new LamaranModel();
        $this->tracerModel  = new TracerModel();
        $this->alumniModel  = new AlumniModel();
        $this->angkatanModel = new AngkatanModel();
        $this->jurusanModel = new JurusanModel();
        $this->aktivitasModel = new AktivitasModel();
        $this->jenisBerkasModel = new JenisBerkasModel();
        $this->syaratBerkasModel = new SyaratBerkasModel();
        $this->riwayatKerjaModel = new RiwayatKerjaModel();
    }

    public function index()
    {
        $userId  = session()->get('id');
        $user    = $this->userModel->find($userId);
        $pelamar = $this->pelamarModel->getByUserId($userId);

        if (!$pelamar) {
            return redirect()->to('/')->with('error', 'Data pelamar tidak ditemukan');
        }

        $idPelamar = $pelamar['id'];

        $berkas  = $this->berkasModel->getByPelamar($idPelamar);
        $lamaran = $this->lamaranModel->getByPelamar($idPelamar);
        $alumni  = $this->alumniModel->getByPelamar($idPelamar);
        $tracer  = $alumni ? $this->tracerModel->getByAlumni($alumni['id']) : null;

        // Kelompokkan berkas berdasarkan jenis
        $berkasMap = [];
        foreach ($berkas as $b) {
            $berkasMap[$b['jenis_berkas']] = $b;
        }

        return view('landing/profil/index', [
            'user'      => $user,
            'pelamar'   => $pelamar,
            'berkas'    => $berkasMap,
            'jenisBerkas' => $this->jenisBerkasModel->getAktif(),
            'lamaran'   => $lamaran,
            'alumni'    => $alumni,
            'tracer'    => $tracer,
        ]);
    }

    public function edit()
    {
        $userId  = session()->get('id');
        $user    = $this->userModel->find($userId);
        $pelamar = $this->pelamarModel->getByUserId($userId);
        $alumni  = $pelamar ? $this->alumniModel->getByPelamar($pelamar['id']) : null;
        $tracer  = $alumni ? $this->tracerModel->getByAlumni($alumni['id']) : null;
        $berkas  = $pelamar ? $this->berkasModel->getByPelamar($pelamar['id']) : [];

        $berkasMap = [];
        foreach ($berkas as $item) {
            $berkasMap[$item['jenis_berkas']] = $item;
        }

        return view('landing/profil/edit', [
            'user'      => $user,
            'pelamar'   => $pelamar,
            'alumni'    => $alumni,
            'tracer'    => $tracer,
            'berkas'    => $berkasMap,
            'jenisBerkas' => $this->jenisBerkasModel->getAktif(),
            'angkatan'  => $this->angkatanModel->orderBy('tahun', 'DESC')->findAll(),
            'jurusan'   => $this->jurusanModel->orderBy('kompetensi_keahlian', 'ASC')->findAll(),
            'aktivitas' => $this->aktivitasModel->orderBy('nama_aktivitas', 'ASC')->findAll(),
        ]);
    }

    public function update()
    {
        $userId = session()->get('id');

        $validationRules = [
            'nama'  => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|max_length[100]',
            'telepon' => 'permit_empty|max_length[20]',
        ];

        $password = $this->request->getPost('password');
        if ($password !== null && $password !== '') {
            $validationRules['password'] = 'required|strong_password';
        }

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update tb_users
        $userData = [
            'nama'  => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
        ];
        if ($password) {
            $userData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        $this->userModel->update($userId, $userData);

        // Update session nama
        session()->set('nama', $this->request->getPost('nama'));

        // Update tb_pelamar
        $pelamarData = [
            'telepon'       => $this->request->getPost('telepon'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tempat_lahir'  => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'alamat'        => $this->request->getPost('alamat'),
            'nomer_nik'     => $this->request->getPost('nomer_nik'),
        ];

        $pelamar = $this->pelamarModel->getByUserId($userId);
        $pelamarData = array_merge(
            $pelamarData,
            $this->buildStatusPendaftaranData(
                $this->request->getPost('status_pendaftaran'),
                $pelamar,
                $userId
            )
        );

        // Upload foto
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move('uploads/foto/', $namaFile);
            $pelamarData['foto'] = $namaFile;
            session()->set('foto', $namaFile);
        }

        if ($pelamar) {
            $this->pelamarModel->where('id_user', $userId)->set($pelamarData)->update();
        } else {
            $pelamarData['id_user'] = $userId;
            $this->pelamarModel->insert($pelamarData);
        }

        return redirect()->to('/profil/edit#tab_data_diri')
            ->with('success', 'Profil berhasil diperbarui')
            ->with('active_tab', 'tab_data_diri');
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

    public function saveTracer()
    {
        $userId = session()->get('id');
        $user   = $this->userModel->find($userId);

        if (($user['id_role'] ?? 0) != 4) {
            return redirect()->to('/profil/edit#tab_data_diri')
                ->with('error', 'Data tracer hanya tersedia untuk akun alumni')
                ->with('active_tab', 'tab_data_diri');
        }

        $pelamar = $this->pelamarModel->getByUserId($userId);
        if (!$pelamar) {
            $pelamarId = $this->pelamarModel->insert(['id_user' => $userId], true);
            $pelamar = $this->pelamarModel->find($pelamarId);
        }

        $alumniData = [
            'id_pelamar'   => $pelamar['id'],
            'id_angkatan'  => $this->request->getPost('id_angkatan') ?: null,
            'id_jurusan'   => $this->request->getPost('id_jurusan') ?: null,
            'nis'          => $this->request->getPost('nis'),
            'nisn'         => $this->request->getPost('nisn'),
            'no_ijazah'    => $this->request->getPost('no_ijazah'),
        ];

        $alumni = $this->alumniModel->getByPelamar($pelamar['id']);
        if ($alumni) {
            $this->alumniModel->update($alumni['id'], $alumniData);
            $alumniId = $alumni['id'];
        } else {
            $alumniId = $this->alumniModel->insert($alumniData, true);
        }

        $idAktivitas = $this->request->getPost('id_aktivitas');
        $aktivitas   = $this->aktivitasModel->find($idAktivitas);

        $slug = strtolower(str_replace(' ', '_', trim(is_array($aktivitas) ? ($aktivitas['nama_aktivitas'] ?? '') : '')));

        $tracerData = [
            'id_alumni'            => $alumniId,
            'id_aktivitas'         => $this->request->getPost('id_aktivitas') ?: null,
            'status'               => $this->request->getPost('status') ?: 'terkirim',
            'posisi_kerja'         => $this->request->getPost('posisi_kerja'),
            'nama_dudi'            => $this->request->getPost('nama_dudi'),
            'bidang_dudi'          => $this->request->getPost('bidang_dudi'),
            'alamat_dudi'          => $this->request->getPost('alamat_dudi'),
            'tahun_mulai_kerja'    => $this->request->getPost('tahun_mulai_kerja'),
            'is_relevan_jurusan'   => $this->request->getPost('is_relevan_jurusan') !== null
                ? $this->request->getPost('is_relevan_jurusan')
                : null,
            'penghasilan_range'    => $this->request->getPost('penghasilan_range'),
            'universitas'          => $this->request->getPost('universitas'),
            'program_studi'        => $this->request->getPost('program_studi'),
            'status_kuliah'        => $this->request->getPost('status_kuliah'),
            'nama_usaha'           => $this->request->getPost('nama_usaha'),
            'bidang_usaha'         => $this->request->getPost('bidang_usaha'),
            'modal_awal'           => $this->request->getPost('modal_awal'),
            'penghasilan_usaha'    => $this->request->getPost('penghasilan_usaha'),
            'rencana_universitas'  => $this->request->getPost('rencana_universitas'),
            'rencana_prodi'        => $this->request->getPost('rencana_prodi'),
        ];

        switch ($slug) {

            case 'bekerja':
                $tracerData['posisi_kerja']       = $this->request->getPost('posisi_kerja');
                $tracerData['nama_dudi']          = $this->request->getPost('nama_dudi');
                $tracerData['bidang_dudi']        = $this->request->getPost('bidang_dudi');
                $tracerData['alamat_dudi']        = $this->request->getPost('alamat_dudi');
                $tracerData['tahun_mulai_kerja']  = $this->request->getPost('tahun_mulai_kerja');
                $tracerData['is_relevan_jurusan'] = $this->request->getPost('is_relevan_jurusan');
                $tracerData['penghasilan_range']  = $this->request->getPost('penghasilan_range');
                break;

            case 'kuliah':
                $tracerData['universitas']   = $this->request->getPost('universitas');
                $tracerData['program_studi'] = $this->request->getPost('program_studi');
                $tracerData['status_kuliah'] = $this->request->getPost('status_kuliah');
                break;

            case 'wirausaha':
                $tracerData['nama_usaha']        = $this->request->getPost('nama_usaha');
                $tracerData['bidang_usaha']      = $this->request->getPost('bidang_usaha');
                $tracerData['modal_awal']        = $this->request->getPost('modal_awal');
                $tracerData['penghasilan_usaha'] = $this->request->getPost('penghasilan_usaha');
                break;

            case 'berencana_kuliah':
                $tracerData['rencana_universitas'] = $this->request->getPost('rencana_universitas');
                $tracerData['rencana_prodi']       = $this->request->getPost('rencana_prodi');
                break;
            case 'mencari_kerja':
                // Tidak ada data tambahan untuk status mencari kerja
                break;

            default:
                // Jika aktivitas tidak dikenali, hapus data spesifik aktivitas
                $tracerData = array_filter($tracerData, function ($key) use ($slug) {
                    return !in_array($key, ['posisi_kerja', 'nama_dudi', 'bidang_dudi', 'alamat_dudi', 'tahun_mulai_kerja', 'is_relevan_jurusan', 'penghasilan_range', 'universitas', 'program_studi', 'status_kuliah', 'nama_usaha', 'bidang_usaha', 'modal_awal', 'penghasilan_usaha', 'rencana_universitas', 'rencana_prodi']);
                }, ARRAY_FILTER_USE_KEY);
                break;
        }

        $tracer = $this->tracerModel->getByAlumni($alumniId);
        if ($tracer) {
            $this->tracerModel->update($tracer['id'], $tracerData);
        } else {
            $this->tracerModel->insert($tracerData);
        }

        $notif = new \App\Libraries\NotificationService();
        $notif->notifyAdminsTracerStudy([
            'id'         => $alumniId,
            'id_pelamar' => $pelamar['id'],
            'id_user'    => $userId,
            'nama'       => $user['nama'] ?? 'Alumni',
        ]);

        return redirect()->to('/profil/edit#tab_tracer')
            ->with('success', 'Data alumni dan tracer berhasil disimpan')
            ->with('active_tab', 'tab_tracer');
    }

    public function uploadBerkas()
    {
        $userId  = session()->get('id');
        $pelamar = $this->pelamarModel->getByUserId($userId);

        if (!$pelamar) {
            return redirect()->back()->with('error', 'Data pelamar tidak ditemukan');
        }

        $idJenisBerkas = (int) $this->request->getPost('id_jenis_berkas');
        $file  = $this->request->getFile('berkas');

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
            // Hapus file lama jika ada
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
                'id_pelamar' => $pelamar['id'],
                'id_jenis_berkas' => $idJenisBerkas,
                'nama_file'  => $file->getClientName(),
                'path_file'  => 'uploads/berkas/' . $namaFile,
                'status'     => 'sudah_diunggah',
            ]);
        }

        return redirect()->to('/profil/edit#tab_berkas')
            ->with('success', 'Berkas berhasil diunggah')
            ->with('active_tab', 'tab_berkas');
    }

    public function riwayatKerja()
    {
        if (strtolower($this->request->getMethod()) !== 'get') {
            return $this->riwayatKerjaJson(false, 'Method tidak diizinkan', [], 405);
        }

        $idPelamar = $this->getSessionPelamarId();
        if (!$idPelamar) {
            return $this->riwayatKerjaJson(false, 'Data pelamar tidak ditemukan', [], 404);
        }

        $data = $this->riwayatKerjaModel
            ->select('id, id_pelamar, nama_perusahaan, posisi_jabatan, tanggal_mulai, tanggal_selesai, is_masih_bekerja, deskripsi_kerja')
            ->where('id_pelamar', $idPelamar)
            ->orderBy('tanggal_mulai', 'DESC')
            ->orderBy('id', 'DESC')
            ->findAll();

        return $this->riwayatKerjaJson(true, 'Data riwayat kerja berhasil diambil', [
            'data' => $data,
        ]);
    }

    public function storeRiwayatKerja()
    {
        if (strtolower($this->request->getMethod()) !== 'post') {
            return $this->riwayatKerjaJson(false, 'Method tidak diizinkan', [], 405);
        }

        $idPelamar = $this->getSessionPelamarId();
        if (!$idPelamar) {
            return $this->riwayatKerjaJson(false, 'Data pelamar tidak ditemukan', [], 404);
        }

        if (!$this->validate($this->riwayatKerjaValidationRules())) {
            return $this->riwayatKerjaJson(false, 'Validasi gagal', [
                'errors' => $this->validator->getErrors(),
            ], 422);
        }

        $this->riwayatKerjaModel->insert($this->buildRiwayatKerjaPayload($idPelamar));

        return $this->riwayatKerjaJson(true, 'Riwayat kerja berhasil ditambahkan');
    }

    public function updateRiwayatKerja(int $id)
    {
        if (strtolower($this->request->getMethod()) !== 'put') {
            return $this->riwayatKerjaJson(false, 'Method tidak diizinkan', [], 405);
        }

        $idPelamar = $this->getSessionPelamarId();
        if (!$idPelamar) {
            return $this->riwayatKerjaJson(false, 'Data pelamar tidak ditemukan', [], 404);
        }

        $riwayat = $this->riwayatKerjaModel
            ->where('id', $id)
            ->where('id_pelamar', $idPelamar)
            ->first();

        if (!$riwayat) {
            return $this->riwayatKerjaJson(false, 'Riwayat kerja tidak ditemukan', [], 404);
        }

        if (!$this->validate($this->riwayatKerjaValidationRules())) {
            return $this->riwayatKerjaJson(false, 'Validasi gagal', [
                'errors' => $this->validator->getErrors(),
            ], 422);
        }

        $this->riwayatKerjaModel->update($id, $this->buildRiwayatKerjaPayload($idPelamar));

        return $this->riwayatKerjaJson(true, 'Riwayat kerja berhasil diperbarui');
    }

    public function destroyRiwayatKerja(int $id)
    {
        if (strtolower($this->request->getMethod()) !== 'delete') {
            return $this->riwayatKerjaJson(false, 'Method tidak diizinkan', [], 405);
        }

        $idPelamar = $this->getSessionPelamarId();
        if (!$idPelamar) {
            return $this->riwayatKerjaJson(false, 'Data pelamar tidak ditemukan', [], 404);
        }

        $riwayat = $this->riwayatKerjaModel
            ->where('id', $id)
            ->where('id_pelamar', $idPelamar)
            ->first();

        if (!$riwayat) {
            return $this->riwayatKerjaJson(false, 'Riwayat kerja tidak ditemukan', [], 404);
        }

        $this->riwayatKerjaModel->delete($id);

        return $this->riwayatKerjaJson(true, 'Riwayat kerja berhasil dihapus');
    }

    private function getSessionPelamarId(): ?int
    {
        $idPelamar = session()->get('id_pelamar');
        if ($idPelamar) {
            return (int) $idPelamar;
        }

        $userId = session()->get('id');
        if (!$userId) {
            return null;
        }

        $pelamar = $this->pelamarModel->getByUserId((int) $userId);
        return $pelamar ? (int) $pelamar['id'] : null;
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
