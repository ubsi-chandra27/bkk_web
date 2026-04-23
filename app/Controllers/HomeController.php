<?php

namespace App\Controllers;

use App\Models\LowonganModel;
use App\Models\PerusahaanModel;
use App\Models\UserModel;
use App\Models\LamaranModel;
use App\Models\PelamarModel;
use App\Models\BerkasModel;
use App\Models\BerkasLamaranModel;
use App\Models\JenisBerkasModel;
use App\Models\SyaratBerkasModel;

class HomeController extends BaseController
{
    protected $lowonganModel;
    protected $perusahaanModel;
    protected $userModel;
    protected $lamaranModel;
    protected $pelamarModel;
    protected $berkasModel;
    protected $berkasLamaranModel;
    protected $jenisBerkasModel;
    protected $syaratBerkasModel;

    public function __construct()
    {
        helper('landing'); // load app/Helpers/landing_helper.php
        $this->lowonganModel   = new LowonganModel();
        $this->perusahaanModel = new PerusahaanModel();
        $this->userModel      = new UserModel();
        $this->lamaranModel   = new LamaranModel();
        $this->pelamarModel   = new PelamarModel();
        $this->berkasModel    = new BerkasModel();
        $this->berkasLamaranModel = new BerkasLamaranModel();
        $this->jenisBerkasModel = new JenisBerkasModel();
        $this->syaratBerkasModel = new SyaratBerkasModel();
    }

    // ---------------------------------------------------------------
    // Beranda / Landing Page
    // ---------------------------------------------------------------
    public function index()
    {
        // Ambil semua lowongan aktif beserta nama perusahaan (pakai method yang sudah ada)
        $semuaLowongan = $this->lowonganModel->getLowongan();

        // Filter hanya yang aktif, ambil 6 terbaru untuk tampil di beranda
        $lowonganAktif = array_filter($semuaLowongan, fn($l) => ($l['status'] ?? '') === 'aktif');
        $lowongans     = array_slice(array_values($lowonganAktif), 0, 6);

        // Semua perusahaan aktif
        $perusahaans = $this->perusahaanModel
            ->where('is_active', 1)
            ->orderBy('nama_perusahaan', 'ASC')
            ->findAll();

        $users = $this->userModel
            ->where('is_active', 1)
            ->findAll();
        $totalPelamar = count(array_filter($users, fn($u) => $u['id_role'] == 4 || $u['id_role'] == 5)); // id_role 4 = pelamar, 5 = alumni
        $totalAlumni = count(array_filter($users, fn($u) => $u['id_role'] == 4)); // id_role 4 = alumni

        $data = [
            'title'        => 'Beranda',
            'lowongans'    => $lowongans,
            'perusahaans'  => $perusahaans,
            'totalLowongan' => count($lowonganAktif),
            'totalPerusahaan' => count($perusahaans),
            'totalPelamar' => $totalPelamar,
            'totalAlumni' => $totalAlumni,
        ];

        return view('landing/index', $data);
    }

    // ---------------------------------------------------------------
    // Halaman daftar lowongan (dengan search)
    // ---------------------------------------------------------------
    public function lowongan()
    {
        $data = [
            'title'     => 'Lowongan Kerja',
            'lowongans' => $this->lowonganModel->getLowonganAktif(),
        ];

        return view('landing/lowongan/index', $data);
    }

    // ---------------------------------------------------------------
    // Detail lowongan
    // ---------------------------------------------------------------
    public function lowonganDetail(int $id)
    {
        $lowongan = $this->lowonganModel->getDetailLowongan($id);
        $syaratBerkas = $this->lowonganModel->getSyaratBerkasByLowongan($id);

        if (!$lowongan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Lowongan tidak ditemukan.');
        }

        $sudahLamar = false;
        $berkasKurang = [];
        $berkasLamaran = [];
        if (session()->get('isLoggedIn') && in_array(session()->get('id_role'), [4, 5])) {
            $userId = session()->get('id');
            $pelamar = $this->pelamarModel->where('id_user', $userId)->first();
            if ($pelamar) {
                $existingLamaran = $this->lamaranModel->where('id_pelamar', $pelamar['id'])->where('id_lowongan', $id)->first();
                $sudahLamar = $existingLamaran ? true : false;
                if ($existingLamaran) {
                    $berkasLamaran = $this->berkasLamaranModel->getByLamaran((int) $existingLamaran['id']);
                }

                if (!empty($syaratBerkas)) {
                    $berkasPelamar = $this->berkasModel->getByPelamar((int) $pelamar['id']);
                    $berkasMap = [];
                    foreach ($berkasPelamar as $berkas) {
                        $berkasMap[(int) $berkas['id_jenis_berkas']] = $berkas;
                    }

                    foreach ($syaratBerkas as $syarat) {
                        if (($syarat['kode'] ?? null) === 'surat_lamaran') {
                            continue;
                        }

                        if (!empty($syarat['is_wajib']) && empty($berkasMap[(int) $syarat['id_jenis_berkas']])) {
                            $berkasKurang[] = $syarat['nama_berkas'];
                        }
                    }
                }
            }
        }

        $data = [
            'title'    => ($lowongan['posisi'] ?? 'Detail Lowongan') . ' - ' . ($lowongan['nama_perusahaan'] ?? 'Perusahaan'),
            'lowongan' => $lowongan,
            'jurusans' => $this->lowonganModel->getJurusanByLowongan($id),
            'syaratBerkas' => $syaratBerkas,
            'sudahLamar' => $sudahLamar,
            'berkasKurang' => $berkasKurang,
            'berkasLamaran' => $berkasLamaran,
        ];

        return view('landing/lowongan/detail', $data);
    }

    // ---------------------------------------------------------------
    // Proses Lamaran
    // ---------------------------------------------------------------
    public function apply(int $id_lowongan)
    {
        if (strtolower($this->request->getMethod()) !== 'post') {
            return redirect()->to('/lowongan/' . $id_lowongan);
        }

        // Cek apakah user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu untuk melamar.');
        }

        $userId = session()->get('id');
        $userRole = session()->get('id_role');

        // Cek apakah role adalah pelamar atau alumni (id_role 4 atau 5)
        if (!in_array($userRole, [4, 5])) {
            return redirect()->to('/')->with('error', 'Hanya pelamar dan alumni yang dapat melamar.');
        }

        // Cek apakah lowongan ada dan aktif
        $lowongan = $this->lowonganModel->where('id', $id_lowongan)->where('status', 'aktif')->first();
        if (!$lowongan) {
            return redirect()->to('/lowongan')->with('error', 'Lowongan tidak ditemukan atau sudah ditutup.');
        }

        // Cek apakah user sudah memiliki data pelamar
        $pelamar = $this->pelamarModel->where('id_user', $userId)->first();
        if (!$pelamar) {
            return redirect()->to('/profil')->with('error', 'Lengkapi data profil pelamar terlebih dahulu.');
        }

        // Cek apakah sudah pernah melamar lowongan ini
        $existingLamaran = $this->lamaranModel->where('id_pelamar', $pelamar['id'])->where('id_lowongan', $id_lowongan)->first();
        if ($existingLamaran) {
            return redirect()->to('/lowongan/' . $id_lowongan)->with('error', 'Anda sudah melamar lowongan ini.');
        }

        $syaratBerkas = $this->syaratBerkasModel->getByLowongan($id_lowongan);
        if (!empty($syaratBerkas)) {
            $berkasPelamar = $this->berkasModel->getByPelamar((int) $pelamar['id']);
            $berkasMap = [];
            foreach ($berkasPelamar as $berkas) {
                $berkasMap[(int) $berkas['id_jenis_berkas']] = $berkas;
            }

            $berkasKurang = [];
            foreach ($syaratBerkas as $syarat) {
                if (($syarat['kode'] ?? null) === 'surat_lamaran') {
                    continue;
                }

                if (!empty($syarat['is_wajib']) && empty($berkasMap[(int) $syarat['id_jenis_berkas']])) {
                    $berkasKurang[] = $syarat['nama_berkas'];
                }
            }

            if (!empty($berkasKurang)) {
                return redirect()->to('/lowongan/' . $id_lowongan)->with(
                    'error',
                    'Lengkapi berkas berikut terlebih dahulu: ' . implode(', ', $berkasKurang) . '.'
                );
            }
        }

        $suratLamaran = $this->request->getFile('surat_lamaran');
        if (!$suratLamaran || !$suratLamaran->isValid()) {
            return redirect()->to('/lowongan/' . $id_lowongan)->with('error', 'File surat lamaran wajib diunggah.');
        }

        $allowedExtensions = ['pdf', 'doc', 'docx'];
        $extension = strtolower((string) $suratLamaran->getClientExtension());
        if (!in_array($extension, $allowedExtensions, true)) {
            return redirect()->to('/lowongan/' . $id_lowongan)->with('error', 'Format surat lamaran harus PDF, DOC, atau DOCX.');
        }

        if ($suratLamaran->getSize() > 2 * 1024 * 1024) {
            return redirect()->to('/lowongan/' . $id_lowongan)->with('error', 'Ukuran surat lamaran maksimal 2 MB.');
        }

        $jenisSuratLamaran = $this->jenisBerkasModel
            ->where('slug_berkas', 'surat_lamaran')
            ->first();

        if (!$jenisSuratLamaran) {
            return redirect()->to('/lowongan/' . $id_lowongan)->with('error', 'Jenis berkas surat lamaran belum tersedia.');
        }

        // Insert lamaran baru dengan status default 'menunggu'
        $dataLamaran = [
            'id_pelamar' => $pelamar['id'],
            'id_lowongan' => $id_lowongan,
            'tanggal_melamar' => date('Y-m-d'),
            'status' => 'menunggu_diverifikasi', // status awal setelah melamar
            'dibuat_oleh' => null,
        ];

        $db = \Config\Database::connect();
        $db->transBegin();

        $savedFilePath = null;

        try {
            $idLamaran = $this->lamaranModel->insert($dataLamaran, true);
            if (!$idLamaran) {
                throw new \RuntimeException('Gagal menyimpan data lamaran.');
            }

            $uploadPath = FCPATH . 'uploads/lamaran/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }

            $namaFile = $suratLamaran->getRandomName();
            $suratLamaran->move($uploadPath, $namaFile);
            $savedFilePath = $uploadPath . $namaFile;

            $isSaved = $this->berkasLamaranModel->insert([
                'id_lamaran'      => $idLamaran,
                'id_jenis_berkas' => $jenisSuratLamaran['id_jenis_berkas'],
                'file_path'       => 'uploads/lamaran/' . $namaFile,
                'file_name'       => $suratLamaran->getClientName(),
                'file_size'       => $suratLamaran->getSize(),
                'uploaded_at'     => date('Y-m-d H:i:s'),
            ]);

            if (!$isSaved) {
                throw new \RuntimeException('Gagal menyimpan file surat lamaran.');
            }

            if (!$db->transStatus()) {
                throw new \RuntimeException('Transaksi penyimpanan lamaran gagal.');
            }

            $db->transCommit();
            return redirect()->to('/lowongan/' . $id_lowongan)->with('success', 'Lamaran Anda berhasil dikirim.');
        } catch (\Throwable $e) {
            $db->transRollback();

            if ($savedFilePath && file_exists($savedFilePath)) {
                unlink($savedFilePath);
            }

            log_message('error', 'Gagal apply lowongan: ' . $e->getMessage());

            return redirect()->to('/lowongan/' . $id_lowongan)->with('error', 'Gagal mengirim lamaran. ' . $e->getMessage());
        }
    }

    // ---------------------------------------------------------------
    // Halaman daftar perusahaan
    // ---------------------------------------------------------------
    public function perusahaan()
    {

        $builder = $this->perusahaanModel
            ->select('tb_perusahaan.*, COUNT(tb_lowongan.id) as total_lowongan')
            ->join('tb_lowongan', "tb_lowongan.id_perusahaan = tb_perusahaan.id AND tb_lowongan.status = 'aktif'", 'left')
            ->where('tb_perusahaan.is_active', 1)
            ->groupBy('tb_perusahaan.id')
            ->orderBy('tb_perusahaan.nama_perusahaan', 'ASC');


        $data = [
            'title'       => 'Perusahaan Mitra',
            'perusahaans' => $builder->findAll(),
        ];

        return view('landing/perusahaan/index', $data);
    }

    // ---------------------------------------------------------------
    // Detail perusahaan
    // ---------------------------------------------------------------
    public function perusahaanDetail(int $id)
    {
        $perusahaan = $this->perusahaanModel->find($id);

        if (!$perusahaan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Perusahaan tidak ditemukan.');
        }

        // Lowongan aktif milik perusahaan ini
        $lowongans = $this->lowonganModel->table('tb_lowongan')
            ->where('id_perusahaan', $id)
            ->where('status', 'aktif')
            ->orderBy('id', 'DESC')
            ->get()->getResultArray();

        $data = [
            'title'      => $perusahaan['nama_perusahaan'],
            'perusahaan' => $perusahaan,
            'lowongans'  => $lowongans,
        ];

        return view('landing/perusahaan_detail', $data);
    }
}
