<?php

namespace App\Http\Controllers\Clients\Notifications;

use App\Services\Dashboard\Notifications\NotificationService;
use Illuminate\Http\JsonResponse;

class NotificationController
{
    public function __construct(protected NotificationService $service){}

    public function index(): JsonResponse
    {
        return $this->service->index();
    }

    public function unreadNotification(): JsonResponse
    {
        return $this->service->unreadNotification();
    }

    public function markAsRead($notifyId): JsonResponse
    {
        return $this->service->markAsRead($notifyId);
    }

    public function markAllAsRead(): JsonResponse
    {
        return $this->service->markAllAsRead();
    }

    public function toggle(): JsonResponse
    {
        return $this->service->toggle();
    }


}
