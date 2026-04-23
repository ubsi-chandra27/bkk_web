<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\JenisBerkasModel;

class DataJenisBerkasController extends BaseController
{
    public function index()
    {
        $model = new JenisBerkasModel();
        $data['jenisBerkas'] = $model->orderBy('nama_berkas', 'ASC')->findAll();

        return view('admin/data_jenis_berkas/index', $data);
    }

    public function store()
    {
        $model = new JenisBerkasModel();
        $slug = $this->normalizeSlug((string) $this->request->getPost('slug_berkas'));
        $now = date('Y-m-d H:i:s');

        $validationRules = [
            'nama_berkas'   => 'required',
            'slug_berkas'   => 'required|is_unique[tb_jenis_berkas.slug_berkas]',
            'berlaku_untuk' => 'required',
        ];

        $this->request->setGlobal('post', array_merge($this->request->getPost(), [
            'slug_berkas' => $slug,
        ]));

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->insert([
            'nama_berkas'    => $this->request->getPost('nama_berkas'),
            'slug_berkas'    => $slug,
            'berlaku_untuk'  => $this->request->getPost('berlaku_untuk'),
            'keterangan'     => $this->request->getPost('keterangan'),
            'status_aktif'   => $this->request->getPost('status_aktif') ?? 1,
            'dibuat_pada'    => $now,
            'diperbarui_pada'=> $now,
        ]);

        return redirect()->to('/admin/data-jenis-berkas')->with('success', 'Jenis berkas berhasil ditambahkan');
    }

    public function update($id)
    {
        $model = new JenisBerkasModel();
        $slug = $this->normalizeSlug((string) $this->request->getPost('slug_berkas'));

        $validationRules = [
            'nama_berkas'   => 'required',
            'slug_berkas'   => 'required|is_unique[tb_jenis_berkas.slug_berkas,id_jenis_berkas,' . $id . ']',
            'berlaku_untuk' => 'required',
        ];

        $this->request->setGlobal('post', array_merge($this->request->getPost(), [
            'slug_berkas' => $slug,
        ]));

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->update($id, [
            'nama_berkas'     => $this->request->getPost('nama_berkas'),
            'slug_berkas'     => $slug,
            'berlaku_untuk'   => $this->request->getPost('berlaku_untuk'),
            'keterangan'      => $this->request->getPost('keterangan'),
            'status_aktif'    => $this->request->getPost('status_aktif') ?? 1,
            'diperbarui_pada' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/data-jenis-berkas')->with('success', 'Jenis berkas berhasil diperbarui');
    }

    public function delete($id)
    {
        $model = new JenisBerkasModel();
        $model->delete($id);

        return redirect()->to('/admin/data-jenis-berkas')->with('success', 'Jenis berkas berhasil dihapus');
    }

    private function normalizeSlug(string $slug): string
    {
        $slug = strtolower(trim($slug));
        $slug = preg_replace('/[^a-z0-9]+/', '_', $slug) ?? '';
        return trim($slug, '_');
    }
}
