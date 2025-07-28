<?php

namespace App\Observers;

use App\Events\NotifyAdminEvent;
use App\Models\AdminProfile;
use App\Models\ClientOffer;
use App\Notifications\AdminNotification;

class ClientOfferObserver
{

    public function created(ClientOffer $clientOffer): void
    {
        $title = "new offer Booked ";
        $body  = 'client '.$clientOffer->clientProfile->user->name.
            ' id = '. $clientOffer->clientProfile->user->id .
            ' booked a new offer id = ' . $clientOffer->id;

        $admin = AdminProfile::find(1);
        $admin->notify(new AdminNotification($title, $body));
        event(new NotifyAdminEvent(1, $title, $body));

    }

    public function updated(ClientOffer $clientOffer): void
    {
        $title = "new session in offer booked";
        $body  = 'client '.$clientOffer->clientProfile->user->name.
            ' id = '. $clientOffer->clientProfile->user->id .
            ' booked a new session in offer id = ' . $clientOffer->id;

        $admin = AdminProfile::find(1);
        $admin->notify(new AdminNotification($title, $body));
        event(new NotifyAdminEvent(1, $title, $body));
    }

    public function deleted(ClientOffer $clientOffer): void
    {

    }

    public function restored(ClientOffer $clientOffer): void
    {
        //
    }

    public function forceDeleted(ClientOffer $clientOffer): void
    {
        //
    }
}
