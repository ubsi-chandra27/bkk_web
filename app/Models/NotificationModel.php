<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table            = 'notifications';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'sender_id',
        'type',
        'title',
        'message',
        'url',
        'is_read',
        'created_at',
        'updated_at',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getUnread(int $userId): array
    {
        return $this->where('user_id', $userId)
            ->where('is_read', 0)
            ->orderBy('created_at', 'DESC')
            ->findAll(20); // maksimal 20 notif ditampilkan
    }

    public function countUnread(int $userId): int
    {
        return $this->where('user_id', $userId)
            ->where('is_read', 0)
            ->countAllResults();
    }

    public function markAllRead(int $userId): void
    {
        $this->where('user_id', $userId)
            ->where('is_read', 0)
            ->set('is_read', 1)
            ->set('updated_at', date('Y-m-d H:i:s'))
            ->update();
    }

    public function markOneRead(int $notifId, int $userId): void
    {
        $this->where('id', $notifId)
            ->where('user_id', $userId) // pastikan hanya bisa baca milik sendiri
            ->set('is_read', 1)
            ->set('updated_at', date('Y-m-d H:i:s'))
            ->update();
    }

    public function sendBulk(array $recipients, array $data): bool
    {
        $rows = [];

        foreach ($recipients as $recipient) {
            $rows[] = [
                'user_id'    => $recipient['id'],
                'sender_id'  => $data['sender_id'] ?? null,
                'type'       => $data['type'],
                'title'      => $data['title'],
                'message'    => $data['message'],
                'url'        => $data['url'] ?? null,
                'is_read'    => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        if (empty($rows)) {
            return false;
        }

        return $this->insertBatch($rows);
    }

    public function sendOne(int $recipientId, array $data): bool
    {
        $now = date('Y-m-d H:i:s');

        return $this->insert([
            'user_id'    => $recipientId,
            'sender_id'  => $data['sender_id'] ?? null,
            'type'       => $data['type'],
            'title'      => $data['title'],
            'message'    => $data['message'],
            'url'        => $data['url'] ?? null,
            'is_read'    => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function deleteOld(int $days = 30): void
    {
        $this->where('created_at <', date('Y-m-d H:i:s', strtotime("-{$days} days")))
            ->where('is_read', 1)
            ->delete();
    }
}
