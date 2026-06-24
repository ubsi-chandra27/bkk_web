<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'tb_users';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'id_role',
        'nama',
        'email',
        'password',
        'auth_provider',
        'google_sub',
        'google_picture',
        'remember_token',
        'reset_token',
        'reset_expires',
        'email_token',
        'email_verified_at',
        'is_verified',
        'is_active',
        'last_login'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getAdmin()
    {
        return $this->db->table('tb_users')
            ->select('tb_users.*, tb_roles.nama_role, tb_admin.jenis_kelamin, tb_admin.telepon, tb_admin.alamat, tb_admin.foto, tb_admin.tanggal_lahir,  tb_perusahaan.id as id_perusahaan')
            ->join('tb_roles', 'tb_roles.id = tb_users.id_role')
            ->join('tb_admin', 'tb_admin.id_user = tb_users.id', 'left')
            ->join('tb_perusahaan', 'tb_perusahaan.id_user = tb_users.id', 'left')
            ->where('tb_users.id_role', 1)
            ->orWhere('tb_users.id_role', 2)
            ->orWhere('tb_users.id_role', 3)
            // No exclusion - show all users
            ->orderBy('tb_users.id', 'DESC')

            ->get()->getResultArray();
    }

    public function getAdminById($id)
    {
        return $this->db->table('tb_users')
            ->select('tb_users.*, tb_roles.nama_role, tb_admin.jenis_kelamin, tb_admin.telepon, tb_admin.alamat, tb_admin.foto, tb_admin.tanggal_lahir')
            ->join('tb_roles', 'tb_roles.id = tb_users.id_role')
            ->join('tb_admin', 'tb_admin.id_user = tb_users.id', 'left')
            ->where('tb_users.id', $id)
            ->get()->getRowArray();
    }
}
