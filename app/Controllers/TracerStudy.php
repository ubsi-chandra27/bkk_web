<?php

namespace App\Controllers;

use App\Models\AktivitasModel;
use App\Models\AlumniModel;
use App\Models\AngkatanModel;
use App\Models\JurusanModel;
use App\Models\PelamarModel;
use App\Models\TracerModel;
use App\Models\UserModel;

class TracerStudy extends BaseController
{
    protected $userModel;
    protected $pelamarModel;
    protected $alumniModel;
    protected $tracerModel;
    protected $angkatanModel;
    protected $jurusanModel;
    protected $aktivitasModel;

    public function __construct()
    {
        helper('landing');

        $this->userModel      = new UserModel();
        $this->pelamarModel   = new PelamarModel();
        $this->alumniModel    = new AlumniModel();
        $this->tracerModel    = new TracerModel();
        $this->angkatanModel  = new AngkatanModel();
        $this->jurusanModel   = new JurusanModel();
        $this->aktivitasModel = new AktivitasModel();
    }

    public function index()
    {
        $userId = session()->get('id');

        if (!$userId || session()->get('id_role') != 4) {
            return redirect()->to('/login')->with('error', 'Halaman ini hanya untuk alumni.');
        }

        $user    = $this->userModel->find($userId);
        $pelamar = $this->pelamarModel->getByUserId($userId);
        $alumni  = $pelamar ? $this->alumniModel->getByPelamar($pelamar['id']) : null;
        $tracer  = $alumni ? $this->tracerModel->getByAlumni($alumni['id']) : null;

        return view('landing/tracer_study/index', [
            'title'     => 'Form Tracer Study',
            'user'      => $user,
            'pelamar'   => $pelamar ?? [],
            'alumni'    => $alumni ?? [],
            'tracer'    => $tracer ?? [],
            'angkatan'  => $this->angkatanModel->orderBy('tahun', 'DESC')->findAll(),
            'jurusan'   => $this->jurusanModel->orderBy('kompetensi_keahlian', 'ASC')->findAll(),
            'aktivitas' => $this->aktivitasModel->orderBy('nama_aktivitas', 'ASC')->findAll(),
        ]);
    }

    public function save()
    {
        $userId = session()->get('id');

        if (!$userId || session()->get('id_role') != 4) {
            return redirect()->to('/login')->with('error', 'Halaman ini hanya untuk alumni.');
        }

        $user = $this->userModel->find($userId);
        if (($user['id_role'] ?? 0) != 4) {
            return redirect()->to('/tracer-study')
                ->with('error', 'Data tracer hanya tersedia untuk akun alumni.');
        }

        $pelamar = $this->pelamarModel->getByUserId($userId);
        if (!$pelamar) {
            $pelamarId = $this->pelamarModel->insert(['id_user' => $userId], true);
            $pelamar   = $this->pelamarModel->find($pelamarId);
        }

        $alumniData = [
            'id_pelamar'  => $pelamar['id'],
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
            $alumniId = $this->alumniModel->insert($alumniData, true);
        }

        $idAktivitas = $this->request->getPost('id_aktivitas');
        $aktivitas   = $this->aktivitasModel->find($idAktivitas);
        $slug        = strtolower(str_replace(' ', '_', trim(is_array($aktivitas) ? ($aktivitas['nama_aktivitas'] ?? '') : '')));

        $tracerData = [
            'id_alumni'           => $alumniId,
            'id_aktivitas'        => $idAktivitas ?: null,
            'status'              => 'terkirim',
            'posisi_kerja'        => null,
            'nama_dudi'           => null,
            'bidang_dudi'         => null,
            'alamat_dudi'         => null,
            'tahun_mulai_kerja'   => null,
            'is_relevan_jurusan'  => null,
            'penghasilan_range'   => null,
            'universitas'         => null,
            'program_studi'       => null,
            'status_kuliah'       => null,
            'nama_usaha'          => null,
            'bidang_usaha'        => null,
            'modal_awal'          => null,
            'penghasilan_usaha'   => null,
            'rencana_universitas' => null,
            'rencana_prodi'       => null,
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

        return redirect()->to('/tracer-study')
            ->with('success', 'Data tracer study berhasil disimpan.');
    }
}
