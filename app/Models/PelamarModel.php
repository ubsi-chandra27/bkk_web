<?php

namespace App\Models;

use CodeIgniter\Model;

class PelamarModel extends Model
{
    protected $table = 'tb_pelamar';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_user',
        'account_id',
        'jenis_pelamar',
        'telepon',
        'foto',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'nomer_nik',
        'status_pendaftaran',
        'terdaftar_pada',
        'diaktivasi_oleh',
        'diaktivasi_pada',
    ];

    protected $beforeInsert = ['setAccountId'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getPelamarWithUser()
    {
        return $this->select('tb_pelamar.*, tb_users.nama, tb_users.email, tb_users.is_active')
            ->join('tb_users', 'tb_users.id = tb_pelamar.id_user')
            ->findAll();
    }

    public function getByUserId($id_user)
    {
        return $this->where('id_user', $id_user)->first();
    }

    protected function setAccountId(array $data): array
    {
        if (! empty($data['data']['account_id'])) {
            return $data;
        }

        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $row = $builder
            ->select('MAX(CAST(SUBSTRING(account_id, 5) AS UNSIGNED)) AS max_number')
            ->get()
            ->getRowArray();

        $nextNumber = (int) ($row['max_number'] ?? 0) + 1;
        $data['data']['account_id'] = sprintf('plm-%03d', $nextNumber);

        return $data;
    }
}
