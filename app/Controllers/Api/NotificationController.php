<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\NotificationModel;
use CodeIgniter\HTTP\ResponseInterface;

class NotificationController extends BaseController
{
    protected $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    public function index(): ResponseInterface
    {
        $userId = session()->get('id');

        if (!$userId) {
            return $this->response->setJSON([
                'error' => 'User not authenticated'
            ])->setStatusCode(401);
        }

        $count = $this->notificationModel->countUnread($userId);
        $notifications = $this->notificationModel->getUnread($userId);

        return $this->response->setJSON([
            'count' => $count,
            'notifications' => $notifications
        ]);
    }

    public function markRead(): ResponseInterface
    {
        $userId = session()->get('id');

        if (!$userId) {
            return $this->response->setJSON([
                'error' => 'User not authenticated'
            ])->setStatusCode(401);
        }

        $this->notificationModel->markAllRead($userId);

        return $this->response->setJSON([
            'status' => 'ok'
        ]);
    }

    public function markOne(): ResponseInterface
    {
        $userId = session()->get('id');
        $notifId = $this->request->getPost('id');

        if (!$userId) {
            return $this->response->setJSON([
                'error' => 'User not authenticated'
            ])->setStatusCode(401);
        }

        if (!$notifId) {
            return $this->response->setJSON([
                'error' => 'Notification ID required'
            ])->setStatusCode(400);
        }

        $this->notificationModel->markOneRead((int) $notifId, $userId);

        return $this->response->setJSON([
            'status' => 'ok'
        ]);
    }
}