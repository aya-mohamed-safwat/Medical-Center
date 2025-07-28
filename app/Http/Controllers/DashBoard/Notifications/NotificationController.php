<?php

namespace App\Http\Controllers\DashBoard\Notifications;

use App\Http\Middleware\CheckPermission;
use Illuminate\Routing\Controller;
use App\Services\Dashboard\Notifications\NotificationService;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    public function __construct(protected NotificationService $service)
    {
        $this->middleware(CheckPermission::class .':delete-notifications')->only(['destroyOne' , 'destroyAll']);
        $this->middleware(CheckPermission::class .':view-notifications')->only(['index' , 'unreadNotification' , 'markAsRead' , 'markAllAsRead']);
    }

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

    public function destroyOne($notifyId): JsonResponse
    {
        return $this->service->destroyOne($notifyId);
    }

    public function destroyAll(): JsonResponse
    {
        return $this->service->destroyAll();
    }
}
