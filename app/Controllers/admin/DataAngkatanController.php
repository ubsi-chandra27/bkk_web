<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\AngkatanModel;

class DataAngkatanController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $data['angkatans'] = $db->table('tb_angkatan')
            ->select('tb_angkatan.*, COUNT(tb_alumni.id) AS terserapan')
            ->join('tb_alumni', 'tb_alumni.id_angkatan = tb_angkatan.id', 'left')
            ->groupBy('tb_angkatan.id')
            ->orderBy('tahun', 'DESC')
            ->get()->getResultArray();

        return view('admin/data_angkatan/index', $data);
    }

    public function store()
    {
        $angkatanModel = new AngkatanModel();

        $validationRules = [
            'tahun_angkatan' => 'required|numeric|is_unique[tb_angkatan.tahun]',
        ];

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $angkatanModel->insert([
            'tahun' => $this->request->getPost('tahun_angkatan'),
        ]);

        return redirect()->to('/admin/data-angkatan')->with('success', 'Data berhasil ditambahkan');
    }

    public function update($id)
    {
        $angkatanModel = new AngkatanModel();

        $validationRules = [
            'tahun_angkatan' => 'required|numeric|is_unique[tb_angkatan.tahun,id,' . $id . ']',
        ];

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $angkatanModel->update($id, [
            'tahun' => $this->request->getPost('tahun_angkatan'),
        ]);

        return redirect()->to('/admin/data-angkatan')->with('success', 'Data berhasil diupdate');
    }

    public function delete($id)
    {
        $angkatanModel = new AngkatanModel();
        $angkatanModel->delete($id);

        return redirect()->to('/admin/data-angkatan')->with('success', 'Data angkatan berhasil dihapus');
    }
}
