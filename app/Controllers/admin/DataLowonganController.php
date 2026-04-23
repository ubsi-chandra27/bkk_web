<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LowonganModel;
use App\Models\PerusahaanModel;
use App\Models\JurusanModel;
use App\Models\LowonganJurusanModel;
use App\Models\JenisBerkasModel;
use App\Models\SyaratBerkasModel;

class DataLowonganController extends BaseController
{
    protected $lowonganModel;
    protected $perusahaanModel;
    protected $jurusanModel;
    protected $lowonganJurusanModel;
    protected $jenisBerkasModel;
    protected $syaratBerkasModel;

    public function __construct()
    {
        $this->lowonganModel  = new LowonganModel();
        $this->perusahaanModel = new PerusahaanModel();
        $this->jurusanModel   = new JurusanModel();
        $this->lowonganJurusanModel = new LowonganJurusanModel();
        $this->jenisBerkasModel = new JenisBerkasModel();
        $this->syaratBerkasModel = new SyaratBerkasModel();
    }

    public function index()
    {
        $lowongan = $this->lowonganModel->getLowongan();

        // Sisipkan jurusan per lowongan
        foreach ($lowongan as &$l) {
            $jurusan = $this->lowonganModel->getJurusanByLowongan($l['id']);
            $l['jurusan']    = array_column($jurusan, 'kompetensi_keahlian');
            $l['id_jurusan'] = array_column($jurusan, 'id');
            $syaratBerkas = $this->lowonganModel->getSyaratBerkasByLowongan((int) $l['id']);
            $l['syarat_berkas'] = $syaratBerkas;
            $l['id_jenis_berkas'] = array_map('intval', array_column($syaratBerkas, 'id_jenis_berkas'));
        }
        unset($l);

        $data['lowongan']  = $lowongan;
        $data['perusahaan'] = $this->perusahaanModel->findAll();
        $data['jurusan']   = $this->jurusanModel->where('is_active', 1)->findAll();
        $data['jenisBerkas'] = $this->jenisBerkasModel->getAktif();

        return view('admin/data_lowongan/index', $data);
    }

    public function show($id)
    {
        $lowongan = $this->lowonganModel->getDetailLowongan($id);

        if (!$lowongan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Lowongan tidak ditemukan.');
        }

        $jurusan = $this->lowonganModel->getJurusanByLowongan($id);
        $lowongan['jurusan']    = array_column($jurusan, 'kompetensi_keahlian');
        $lowongan['id_jurusan'] = array_column($jurusan, 'id');
        $lowongan['syarat_berkas'] = $this->lowonganModel->getSyaratBerkasByLowongan($id);
        $lowongan['id_jenis_berkas'] = array_map('intval', array_column($lowongan['syarat_berkas'], 'id_jenis_berkas'));

        $data = [
            'title'       => 'Detail Lowongan',
            'lowongan'    => $lowongan,
            'logoUrl'     => !empty($lowongan['logo']) ? base_url('uploads/logo/' . $lowongan['logo']) : null,
            'perusahaan'  => $this->perusahaanModel->findAll(),
            'jurusan'     => $this->jurusanModel->where('is_active', 1)->findAll(),
            'jenisBerkas' => $this->jenisBerkasModel->getAktif(),
        ];

        return view('admin/data_lowongan/detail_lowongan', $data);
    }

    public function store()
    {
        $rules = [
            'id_perusahaan'      => 'required',
            'posisi'             => 'required',
            'jenis_pekerjaan'    => 'required',
            'batas_lamaran'      => 'required',
            'status'             => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id_perusahaan'      => $this->request->getPost('id_perusahaan'),
            'posisi'             => $this->request->getPost('posisi'),
            'deskripsi_pekerjaan' => $this->request->getPost('deskripsi_pekerjaan'),
            'kualifikasi'        => $this->request->getPost('kualifikasi'),
            'jenis_pekerjaan'    => $this->request->getPost('jenis_pekerjaan'),
            'lokasi_kerja'       => $this->request->getPost('lokasi_kerja'),
            'batas_lamaran'      => $this->request->getPost('batas_lamaran'),
            'status'             => $this->request->getPost('status'),
            'dibuat_oleh'        => session()->get('id'),
        ];

        $this->lowonganModel->insert($data);
        $idLowongan = $this->lowonganModel->getInsertID();

        // Simpan jurusan ke tb_lowongan_jurusan
        $jurusanIds = $this->request->getPost('jurusan') ?? [];
        foreach ($jurusanIds as $idJurusan) {
            $this->lowonganJurusanModel->insert([
                'id_lowongan' => $idLowongan,
                'id_jurusan'  => $idJurusan,
            ]);
        }

        $this->syncSyaratBerkas($idLowongan, $this->request->getPost('jenis_berkas'));

        return redirect()->to('/admin/data-lowongan')->with('success', 'Lowongan berhasil ditambahkan');
    }

    public function update($id)
    {
        $rules = [
            'id_perusahaan'   => 'required',
            'posisi'          => 'required',
            'jenis_pekerjaan' => 'required',
            'batas_lamaran'   => 'required',
            'status'          => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id_perusahaan'      => $this->request->getPost('id_perusahaan'),
            'posisi'             => $this->request->getPost('posisi'),
            'deskripsi_pekerjaan' => $this->request->getPost('deskripsi_pekerjaan'),
            'kualifikasi'        => $this->request->getPost('kualifikasi'),
            'jenis_pekerjaan'    => $this->request->getPost('jenis_pekerjaan'),
            'lokasi_kerja'       => $this->request->getPost('lokasi_kerja'),
            'batas_lamaran'      => $this->request->getPost('batas_lamaran'),
            'status'             => $this->request->getPost('status'),
        ];

        $this->lowonganModel->update($id, $data);

        // Sync jurusan
        $this->lowonganJurusanModel->where('id_lowongan', $id)->delete();
        $jurusanIds = $this->request->getPost('jurusan') ?? [];
        foreach ($jurusanIds as $idJurusan) {
            $this->lowonganJurusanModel->insert([
                'id_lowongan' => $id,
                'id_jurusan'  => $idJurusan,
            ]);
        }

        $this->syncSyaratBerkas((int) $id, $this->request->getPost('jenis_berkas'));

        return redirect()->to('/admin/data-lowongan')->with('success', 'Lowongan berhasil diupdate');
    }

    public function delete($id)
    {
        $this->lowonganJurusanModel->where('id_lowongan', $id)->delete();
        $this->syaratBerkasModel->where('id_lowongan', $id)->delete();
        $this->lowonganModel->delete($id);
        return redirect()->to('/admin/data-lowongan')->with('success', 'Lowongan berhasil dihapus');
    }

    private function syncSyaratBerkas(int $idLowongan, $jenisBerkasIds): void
    {
        $this->syaratBerkasModel->where('id_lowongan', $idLowongan)->delete();

        foreach ((array) $jenisBerkasIds as $idJenisBerkas) {
            $idJenisBerkas = (int) $idJenisBerkas;
            if ($idJenisBerkas <= 0) {
                continue;
            }

            $this->syaratBerkasModel->insert([
                'id_lowongan'     => $idLowongan,
                'id_jenis_berkas' => $idJenisBerkas,
                'wajib'           => 1,
            ]);
        }
    }
}
