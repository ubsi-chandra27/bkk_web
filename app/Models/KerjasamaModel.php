<?php

namespace App\Models;

use CodeIgniter\Model;

class KerjasamaModel extends Model
{
    protected $table = 'tb_kerjasama';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_kerjasama',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
