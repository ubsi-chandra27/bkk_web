<?php

namespace App\Models;

use CodeIgniter\Model;

class TracerModel extends Model
{
    protected $table      = 'tb_tracer_alumni';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_alumni',
        'id_aktivitas',
        'status',
        'diverifikasi_oleh',
        'diverifikasi_at',
        'disetujui_oleh',
        'disetujui_at',
        'posisi_kerja',
        'nama_dudi',
        'bidang_dudi',
        'alamat_dudi',
        'tahun_mulai_kerja',
        'is_relevan_jurusan',
        'penghasilan_range',
        'universitas',
        'program_studi',
        'status_kuliah',
        'nama_usaha',
        'bidang_usaha',
        'modal_awal',
        'penghasilan_usaha',
        'rencana_universitas',
        'rencana_prodi',
    ];
    protected $useTimestamps = true;

    public function getByAlumni($idAlumni)
    {
        return $this->db->table('tb_tracer_alumni')
            ->select('tb_tracer_alumni.*, tb_aktivitas.nama_aktivitas')
            ->join('tb_aktivitas', 'tb_aktivitas.id = tb_tracer_alumni.id_aktivitas', 'left')
            ->where('tb_tracer_alumni.id_alumni', $idAlumni)
            ->get()->getRowArray();
    }
}
