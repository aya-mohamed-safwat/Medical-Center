<?php

namespace App\Observers;

use App\Events\NotifyAdminEvent;
use App\Models\AdminProfile;
use App\Models\Appointment;
use App\Models\ClientProfile;
use App\Models\User;
use App\Notifications\AdminNotification;
use App\Notifications\ClientNotification;
use Illuminate\Support\Facades\Log;

class AppointmentObserver
{
    public function created(Appointment $appointment): void
    {
        $title = "new session Booked ";
        $body  = 'client '.$appointment->client->user->name.
            'id = '. $appointment->client->user->id .
            'booked a new session id = ' . $appointment->id;

        $admin = AdminProfile::find(1);

        $admin->notify(new AdminNotification($title, $body));
        event(new NotifyAdminEvent(1, $title, $body));
    }

    public function updated(Appointment $appointment): void
    {
        if(auth()->user()->role_id === 3){
            $title = "session Updated";
            $body  = 'user update the session where id = ' . $appointment->id ;

            $admin = AdminProfile::find(1);

            $admin->notify(new AdminNotification($title, $body));
            event(new NotifyAdminEvent(1, $title, $body));
        }
        if(auth()->user()->role_id === 1){
            $title  = "admin update your session";
            $body   = 'update status to '.$appointment->status->value;

            $appointment->client->user->notify(new clientNotification($body, $title));
        }
    }

    public function deleted(Appointment $appointment): void
    {
        //
    }

    public function restored(Appointment $appointment): void
    {
        //
    }

    public function forceDeleted(Appointment $appointment): void
    {
        //
    }
}
