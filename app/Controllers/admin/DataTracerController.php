<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Libraries\ExportAlumniExcel;
use App\Models\AngkatanModel;
use App\Models\TracerModel;
use App\Models\AlumniModel;
use App\Models\JurusanModel;
use App\Models\PelamarModel;
use App\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DataTracerController extends BaseController
{
    protected $tracerModel;
    protected $alumniModel;
    protected $pelamarModel;
    protected $userModel;

    public function __construct()
    {
        $this->tracerModel = new TracerModel();
        $this->alumniModel = new AlumniModel();
        $this->pelamarModel = new PelamarModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $filters = [
            'jurusan' => $this->request->getGet('jurusan'),
            'angkatan' => $this->request->getGet('angkatan'),
            'aktivitas' => $this->request->getGet('aktivitas'),
        ];

        $data = [
            'tracers' => $this->tracerModel->getFiltered($filters),
            'filters' => $filters,
            'jurusanList' => $this->tracerModel->getFilterJurusanOptions(),
            'angkatanList' => $this->tracerModel->getFilterAngkatanOptions(),
            'aktivitasList' => $this->tracerModel->getFilterAktivitasOptions(),
        ];

        return view('admin/data_tracer/index', $data);
    }

    public function exportExcel()
    {
        $filters = [
            'id_jurusan' => $this->request->getGet('id_jurusan'),
            'id_angkatan' => $this->request->getGet('id_angkatan'),
            'id_aktivitas' => $this->request->getGet('id_aktivitas'),
        ];

        $jurusanModel = new JurusanModel();
        $angkatanModel = new AngkatanModel();

        $jurusanList = $jurusanModel->orderBy('kompetensi_keahlian', 'ASC')->findAll();
        $angkatanList = $angkatanModel->orderBy('tahun', 'ASC')->findAll();
        $exportData = $this->tracerModel->getExportData($filters);

        $spreadsheet = (new ExportAlumniExcel())->generate($exportData, $filters, $jurusanList, $angkatanList);
        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan_alumni_' . date('Ymd_His') . '.xlsx';

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        ob_start();
        $writer->save('php://output');
        $contents = (string) ob_get_clean();

        return $this->response
            ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setHeader('Cache-Control', 'max-age=0')
            ->setBody($contents);
    }

    public function update($id)
    {
        $tracer = $this->tracerModel->find($id);
        if (!$tracer) {
            return redirect()->to('admin/data-tracer')->with('error', 'Data tracer tidak ditemukan');
        }

        $status = $this->request->getPost('status');
        $userId = session()->get('id');

        $updateData = ['status' => $status];

        if ($status === 'terverifikasi') {
            $updateData['diverifikasi_oleh'] = $userId;
            $updateData['diverifikasi_at'] = date('Y-m-d H:i:s');
        } elseif ($status === 'disetujui') {
            $updateData['disetujui_oleh'] = $userId;
            $updateData['disetujui_at'] = date('Y-m-d H:i:s');
        }

        if ($this->tracerModel->update($id, $updateData)) {
            return redirect()->to('admin/data-tracer')->with('success', 'Status tracer berhasil diperbarui');
        } else {
            return redirect()->to('admin/data-tracer')->with('error', 'Gagal memperbarui status tracer');
        }
    }

    public function delete($id)
    {
        if ($this->tracerModel->delete($id)) {
            return redirect()->to('admin/data-tracer')->with('success', 'Data tracer berhasil dihapus');
        } else {
            return redirect()->to('admin/data-tracer')->with('error', 'Gagal menghapus data tracer');
        }
    }

    private function getTracerData($id = null)
    {
        $query = $this->tracerModel->db->table('tb_tracer_alumni')
            ->select('
                tb_tracer_alumni.*,
                tb_alumni.id_pelamar,
                tb_users.id as id_user,
                tb_users.nama,
                tb_jurusan.kompetensi_keahlian,
                tb_jurusan.akronim,
                tb_angkatan.tahun,
                tb_aktivitas.nama_aktivitas
            ')
            ->join('tb_alumni', 'tb_alumni.id = tb_tracer_alumni.id_alumni', 'left')
            ->join('tb_pelamar', 'tb_pelamar.id = tb_alumni.id_pelamar', 'left')
            ->join('tb_users', 'tb_users.id = tb_pelamar.id_user', 'left')
            ->join('tb_jurusan', 'tb_jurusan.id = tb_alumni.id_jurusan', 'left')
            ->join('tb_angkatan', 'tb_angkatan.id = tb_alumni.id_angkatan', 'left')
            ->join('tb_aktivitas', 'tb_aktivitas.id = tb_tracer_alumni.id_aktivitas', 'left');

        if ($id) {
            return $query->where('tb_tracer_alumni.id', $id)->get()->getRowArray();
        }

        return $query->get()->getResultArray();
    }
}
