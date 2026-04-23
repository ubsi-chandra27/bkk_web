<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\KerjasamaModel;

class DataKerjasamaController extends BaseController
{
    public function index()
    {
        $kerjasamaModel = new KerjasamaModel();
        $data['kerjasama'] = $kerjasamaModel->orderBy('nama_kerjasama', 'DESC')->findAll();

        return view('admin/data_kerjasama/index', $data);
    }

    public function store()
    {
        $kerjasamaModel = new KerjasamaModel();

        $validationRules = [
            'nama_kerjasama' => 'required|is_unique[tb_kerjasama.nama_kerjasama]',
        ];

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $kerjasamaModel->insert([
            'nama_kerjasama' => $this->request->getPost('nama_kerjasama'),
        ]);

        return redirect()->to('/admin/data-kerjasama')->with('success', 'Data berhasil ditambahkan');
    }

    public function update($id)
    {
        $kerjasamaModel = new KerjasamaModel();

        $validationRules = [
            'nama_kerjasama' => 'required|is_unique[tb_kerjasama.nama_kerjasama,id,' . $id . ']',
        ];

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $kerjasamaModel->update($id, [
            'nama_kerjasama' => $this->request->getPost('nama_kerjasama'),
        ]);

        return redirect()->to('/admin/data-kerjasama')->with('success', 'Data berhasil diupdate');
    }

    public function delete($id)
    {
        $kerjasamaModel = new KerjasamaModel();
        $kerjasamaModel->delete($id);

        return redirect()->to('/admin/data-kerjasama')->with('success', 'Data kerjasama berhasil dihapus');
    }
}
