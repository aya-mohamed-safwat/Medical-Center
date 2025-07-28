<?php

namespace App\Observers;

use App\Events\NotifyAdminEvent;
use App\Models\AdminProfile;
use App\Models\Payment;
use App\Notifications\AdminNotification;

class PaymentObserver
{
    public function created(Payment $payment): void
    {
        $title = " user pay for new offer ";
        $body  = 'client id = '. $payment->user_id .
            ' payment id = ' . $payment->id .
            ' offer id = ' .$payment->offer_id ;

        $admin = AdminProfile::find(1);
        $admin->notify(new AdminNotification($title, $body));
        event(new NotifyAdminEvent(1, $title, $body));
    }

    public function updated(Payment $payment): void
    {
        //
    }

    public function deleted(Payment $payment): void
    {
        //
    }

    public function restored(Payment $payment): void
    {
        //
    }

    public function forceDeleted(Payment $payment): void
    {
        //
    }
}
