<?php

namespace App\Channels;

use App\Services\Clients\Fcm\FcmService;
use Illuminate\Notifications\Notification;

class FcmChannel
{
    public function send($notifiable , Notification $notification): void
    {
        $deviceToken = $notifiable->routeNotificationFor('fcm');
        if (!$deviceToken) {
            return;
        }
        $message = $notification->toFcm($notifiable);

        $fcm = new FcmService();
        $fcm->sendNotification($deviceToken, $message['title'], $message['body']);
    }
}
