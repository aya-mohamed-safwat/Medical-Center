<?php

namespace App\Services\Dashboard\Notifications;

use App\Http\Resources\Dashboard\Notifications\NotificationResource;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\json;

class NotificationService
{
    protected ? Authenticatable $user;
    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function index():JsonResponse
    {
        $notifications = $this->user->notifications()->latest()->paginate();
        return json(__('response.success'),__('response.index'),NotificationResource::collection($notifications),200);
    }

    public function unreadNotification():JsonResponse
    {
        $notifications = $this->user->unreadNotifications()->latest()->paginate();
        return json(__('response.success'),__('response.index'),NotificationResource::collection($notifications),200);
    }

    public function markAsRead($notifyId):JsonResponse
    {
        $notification= $this->user->notifications()->where('id',$notifyId)->firstOrFail();

        $notification->markAsRead();
        return json(__('response.success'),'notification marked as read','',200);
    }

    public function markAllAsRead():JsonResponse
    {
        $this->user->unreadNotifications->markAsRead();
        return json(__('response.success'),'All notifications marked as read','',200);
    }

    public function destroyOne($notifyId):JsonResponse
    {
        $notification = $this->user->notifications()->where('id',$notifyId)->firstOrFail();

        $notification->delete();
        return json(__('response.success'),__('response.done.delete'),'',200);
    }

    public function destroyAll():JsonResponse
    {
        $this->user->notifications()->delete();
        return json(__('response.success'),__('response.done.delete'),'',200);
    }

    public function toggle():JsonResponse
    {
        $user = User::findOrFail(auth()->id());

        $user->notification = !$user->notification ;
        $user->save();
        return json(__('response.success'),'',['data' => $user->notification ],200);
    }
}
