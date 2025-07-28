<?php

namespace App\Notifications;

use App\Channels\FcmChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ClientNotification extends Notification
{
    use Queueable;

    public function __construct(protected $title, protected $body){}

    public function via(object $notifiable): array
    {
        $channels = ['database'];
//        if($notifiable->notification){
//            $channels[] = FcmChannel::class;
//        }
        return $channels;
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => $this->title,
            'body'  => $this->body,
        ];
    }

//    public function toFcm($notifiable): array
//    {
//        return [
//            'title' => $this->title,
//            'body'  => $this->body,
//        ];
//    }
}
