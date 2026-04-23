<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\AktivitasModel;

class DataAktivitasController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $data['aktivitas'] = $db->table('tb_aktivitas')
            ->select('tb_aktivitas.*, COUNT(DISTINCT tb_tracer_alumni.id_alumni) AS terserapan')
            ->join('tb_tracer_alumni', 'tb_tracer_alumni.id_aktivitas = tb_aktivitas.id', 'left')
            ->groupBy('tb_aktivitas.id')
            ->orderBy('nama_aktivitas', 'ASC')
            ->get()->getResultArray();

        return view('admin/data_aktivitas/index', $data);
    }

    public function store()
    {
        $aktivitasModel = new AktivitasModel();

        $validationRules = [
            'nama_aktivitas' => 'required|is_unique[tb_aktivitas.nama_aktivitas]',
        ];

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $aktivitasModel->insert([
            'nama_aktivitas' => $this->request->getPost('nama_aktivitas'),
        ]);

        return redirect()->to('/admin/data-aktivitas')->with('success', 'Data berhasil ditambahkan');
    }

    public function update($id)
    {
        $aktivitasModel = new AktivitasModel();

        $validationRules = [
            'nama_aktivitas' => 'required|is_unique[tb_aktivitas.nama_aktivitas,id,' . $id . ']',
        ];

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $aktivitasModel->update($id, [
            'nama_aktivitas' => $this->request->getPost('nama_aktivitas'),
        ]);

        return redirect()->to('/admin/data-aktivitas')->with('success', 'Data berhasil diupdate');
    }

    public function delete($id)
    {
        $aktivitasModel = new AktivitasModel();
        $aktivitasModel->delete($id);

        return redirect()->to('/admin/data-aktivitas')->with('success', 'Data aktivitas berhasil dihapus');
    }
}
