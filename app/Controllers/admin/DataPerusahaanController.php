<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PerusahaanModel;
use App\Models\KerjasamaModel;
use App\Models\MouModel;

class DataPerusahaanController extends BaseController
{
    protected $perusahaanModel;

    public function __construct()
    {
        $this->perusahaanModel = new PerusahaanModel();
    }

    public function index()
    {

        $data['perusahaan'] = $this->perusahaanModel->findAll();

        $kerjasamaModel = new KerjasamaModel();
        $mouModel = new MouModel();

        $data['kerjasama'] = $kerjasamaModel->findAll();
        $data['mou'] = $mouModel->getMou();

        // Kelompokkan nama kerjasama berdasarkan id_perusahaan
        $kerjasamaPerPerusahaan = [];
        foreach ($data['mou'] as $mou) {
            $idP = $mou['id_perusahaan'];
            $kerjasamaPerPerusahaan[$idP][] = $mou['nama_kerjasama'];
        }

        // Sisipkan ke array perusahaan
        foreach ($data['perusahaan'] as &$p) {
            $p['kerjasama'] = $kerjasamaPerPerusahaan[$p['id']] ?? [];
        }
        unset($p);

        $data['perusahaan']             = $data['perusahaan'];
        $data['kerjasama']              = $kerjasamaModel->findAll();
        $data['kerjasamaPerPerusahaan'] = array_map(
            fn($mous) => array_column($mous, null, 'id_kerjasama') ?
                array_keys(array_flip(array_column(
                    array_filter($data['mou'], fn($m) => $m['id_perusahaan'] == key($kerjasamaPerPerusahaan)),
                    'id_kerjasama'
                ))) : [],
            $kerjasamaPerPerusahaan
        );


        return view('admin/data_perusahaan/index', $data);
    }

    public function store()
    {
        $rules = [
            'nama_perusahaan' => 'required',
            'bidang_usaha' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'no_telepon' => 'required',
            'email' => 'required|valid_email',
            'website' => 'required|valid_url',
            'logo' => 'max_size[logo,1024]|is_image[logo]|mime_in[logo,image/jpg,image/jpeg,image/png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_perusahaan' => $this->request->getPost('nama_perusahaan'),
            'bidang_usaha' => $this->request->getPost('bidang_usaha'),
            'alamat' => $this->request->getPost('alamat'),
            'kota' => $this->request->getPost('kota'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'email' => $this->request->getPost('email'),
            'website' => $this->request->getPost('website'),
            'id_user' => null, // Kosongkan dulu
        ];

        $logo = $this->request->getFile('logo');
        if ($logo && $logo->isValid()) {
            $logoName = $logo->getRandomName();
            $logo->move('uploads/logo', $logoName);
            $data['logo'] = $logoName;
        }

        $this->perusahaanModel->insert($data);

        $idPerusahaan = $this->perusahaanModel->insertID(); // tambah ini

        // ✅ Simpan kerjasama ke tb_mou
        $mouModel = new MouModel();
        $kerjasamaIds = $this->request->getPost('kerjasama') ?? [];
        foreach ($kerjasamaIds as $idKerjasama) {
            $mouModel->insert([
                'id_perusahaan' => $idPerusahaan,
                'id_kerjasama'  => $idKerjasama,
                'status'        => 'aktif',
                'created_by'    => session()->get('id'),
            ]);
        }
        return redirect()->to('/admin/data-perusahaan')->with('success', 'Data perusahaan berhasil ditambahkan');
    }

    public function update($id)
    {
        $rules = [
            'nama_perusahaan' => 'required',
            'bidang_usaha' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'no_telepon' => 'required',
            'email' => 'required|valid_email',
            'website' => 'required|valid_url',
            'logo' => 'max_size[logo,1024]|is_image[logo]|mime_in[logo,image/jpg,image/jpeg,image/png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_perusahaan' => $this->request->getPost('nama_perusahaan'),
            'bidang_usaha' => $this->request->getPost('bidang_usaha'),
            'alamat' => $this->request->getPost('alamat'),
            'kota' => $this->request->getPost('kota'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'email' => $this->request->getPost('email'),
            'website' => $this->request->getPost('website'),
        ];

        $logo = $this->request->getFile('logo');
        if ($logo && $logo->isValid()) {
            $logoName = $logo->getRandomName();
            $logo->move('uploads/logo', $logoName);
            $data['logo'] = $logoName;
        }

        $this->perusahaanModel->update($id, $data);

        // ✅ Sync kerjasama di tb_mou
        $mouModel = new MouModel();
        $kerjasamaIds = $this->request->getPost('kerjasama') ?? [];

        // Hapus MOU lama yang belum punya nomor_mou (belum dilengkapi)
        $mouModel->where('id_perusahaan', $id)
            ->where('nomor_mou IS NULL', null, false)
            ->delete();

        // Buat ulang MOU baru dari kerjasama yang dipilih
        foreach ($kerjasamaIds as $idKerjasama) {
            $mouModel->insert([
                'id_perusahaan' => $id,
                'id_kerjasama'  => $idKerjasama,
                'status'        => 'aktif',
                'created_by'    => session()->get('id'),
            ]);
        }


        return redirect()->to('/admin/data-perusahaan')->with('success', 'Data perusahaan berhasil diupdate');
    }

    public function delete($id)
    {
        $this->perusahaanModel->delete($id);
        return redirect()->to('/admin/data-perusahaan')->with('success', 'Data perusahaan berhasil dihapus');
    }
}
