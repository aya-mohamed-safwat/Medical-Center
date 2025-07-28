<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Models\ClientOffer;
use App\Models\Payment;
use App\Observers\AppointmentObserver;
use App\Observers\ClientOfferObserver;
use App\Observers\PaymentObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Appointment::observe(AppointmentObserver::class);
        ClientOffer::observe(ClientOfferObserver::class);
        Payment::observe(PaymentObserver::class);
    }
}
