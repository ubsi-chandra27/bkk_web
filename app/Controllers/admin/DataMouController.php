<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MouModel;
use App\Models\PerusahaanModel;
use App\Models\KerjasamaModel;

class DataMouController extends BaseController
{
    protected $mouModel;
    protected $perusahaanModel;
    protected $kerjasamaModel;

    public function __construct()
    {
        $this->mouModel       = new MouModel();
        $this->perusahaanModel = new PerusahaanModel();
        $this->kerjasamaModel  = new KerjasamaModel();
    }

    public function index()
    {
        $data['mous']       = $this->mouModel->getMou();
        $data['perusahaan'] = $this->perusahaanModel->findAll();
        $data['kerjasama']  = $this->kerjasamaModel->findAll();

        $perusahaan = $this->perusahaanModel->findAll();

        // Ambil kerjasama yang sudah terpilih per perusahaan
        $kerjasamaPerPerusahaan = [];
        foreach ($perusahaan as $p) {
            $mous = $this->mouModel->where('id_perusahaan', $p['id'])
                ->where('nomor_mou IS NULL', null, false)
                ->findAll();
            $kerjasamaPerPerusahaan[$p['id']] = array_column($mous, 'id_kerjasama');
        }

        $data['perusahaan']              = $perusahaan;
        $data['kerjasama']               = $this->kerjasamaModel->findAll();
        $data['kerjasamaPerPerusahaan']  = $kerjasamaPerPerusahaan;

        return view('admin/data_mou/index', $data);
    }

    public function store()
    {
        $rules = [
            'id_perusahaan'   => 'required',
            'id_kerjasama'    => 'required',
            'nomor_mou'       => 'required',
            'tanggal_mou'     => 'required',
            'tanggal_berlaku' => 'required',
            'tanggal_berakhir' => 'required',
            'status'          => 'required',
            'file_mou'        => 'max_size[file_mou,2048]|ext_in[file_mou,pdf,jpg,jpeg,png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id_perusahaan'   => $this->request->getPost('id_perusahaan'),
            'id_kerjasama'    => $this->request->getPost('id_kerjasama'),
            'nomor_mou'       => $this->request->getPost('nomor_mou'),
            'tanggal_mou'     => $this->request->getPost('tanggal_mou'),
            'tanggal_berlaku' => $this->request->getPost('tanggal_berlaku'),
            'tanggal_berakhir' => $this->request->getPost('tanggal_berakhir'),
            'status'          => $this->request->getPost('status'),
            'created_by'      => session()->get('id'),
        ];

        $file = $this->request->getFile('file_mou');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move('uploads/mou/', $namaFile);
            $data['file_mou'] = $namaFile;
        }

        $this->mouModel->insert($data);
        return redirect()->to('/admin/data-mou')->with('success', 'Data MOU berhasil ditambahkan');
    }

    public function update($id)
    {
        $rules = [
            'id_perusahaan'   => 'required',
            'id_kerjasama'    => 'required',
            'nomor_mou'       => 'required',
            'tanggal_mou'     => 'required',
            'tanggal_berlaku' => 'required',
            'tanggal_berakhir' => 'required',
            'status'          => 'required',
            'file_mou'        => 'max_size[file_mou,2048]|ext_in[file_mou,pdf,jpg,jpeg,png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id_perusahaan'   => $this->request->getPost('id_perusahaan'),
            'id_kerjasama'    => $this->request->getPost('id_kerjasama'),
            'nomor_mou'       => $this->request->getPost('nomor_mou'),
            'tanggal_mou'     => $this->request->getPost('tanggal_mou'),
            'tanggal_berlaku' => $this->request->getPost('tanggal_berlaku'),
            'tanggal_berakhir' => $this->request->getPost('tanggal_berakhir'),
            'status'          => $this->request->getPost('status'),
        ];

        $file = $this->request->getFile('file_mou');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move('uploads/mou/', $namaFile);
            $data['file_mou'] = $namaFile;
        }

        $this->mouModel->update($id, $data);
        return redirect()->to('/admin/data-mou')->with('success', 'Data MOU berhasil diupdate');
    }

    public function delete($id)
    {
        $this->mouModel->delete($id);
        return redirect()->to('/admin/data-mou')->with('success', 'Data MOU berhasil dihapus');
    }
}
