<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\JurusanModel;

class DataJurusanController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $data['jurusan'] = $db->table('tb_jurusan')
            ->select('tb_jurusan.*, COUNT(tb_alumni.id) AS terserapan')
            ->join('tb_alumni', 'tb_alumni.id_jurusan = tb_jurusan.id', 'left')
            ->groupBy('tb_jurusan.id')
            ->orderBy('kompetensi_keahlian', 'ASC')
            ->get()->getResultArray();

        return view('admin/data_jurusan/index', $data);
    }

    public function store()
    {
        $jurusanModel = new JurusanModel();

        $validationRules = [
            'kompetensi_keahlian' => 'required|is_unique[tb_jurusan.kompetensi_keahlian]',
            'akronim' => 'required|is_unique[tb_jurusan.akronim]',
        ];

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $jurusanModel->insert([
            'kompetensi_keahlian' => $this->request->getPost('kompetensi_keahlian'),
            'akronim' => $this->request->getPost('akronim'),
        ]);

        return redirect()->to('/admin/data-jurusan')->with('success', 'Data berhasil ditambahkan');
    }

    public function update($id)
    {
        $jurusanModel = new JurusanModel();

        $validationRules = [
            'kompetensi_keahlian' => 'required|is_unique[tb_jurusan.kompetensi_keahlian,id,' . $id . ']',
            'akronim' => 'required|is_unique[tb_jurusan.akronim,id,' . $id . ']',
        ];

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $jurusanModel->update($id, [
            'kompetensi_keahlian' => $this->request->getPost('kompetensi_keahlian'),
            'akronim' => $this->request->getPost('akronim'),
        ]);

        return redirect()->to('/admin/data-jurusan')->with('success', 'Data berhasil diupdate');
    }

    public function delete($id)
    {
        $jurusanModel = new JurusanModel();
        $jurusanModel->delete($id);

        return redirect()->to('/admin/data-jurusan')->with('success', 'Data jurusan berhasil dihapus');
    }
}
