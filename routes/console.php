<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $expiredOffers = DB::table('client_offers')
        ->join('offers', 'client_offers.offer_id', '=', 'offers.id')
        ->where('client_offers.is_paid', false)
        ->whereRaw("client_offers.created_at + INTERVAL offers.payment_timeout DAY < NOW()")
        ->pluck('client_offers.id');

    DB::table('client_offers')
        ->whereIn('id', $expiredOffers)
        ->delete();
})->everyMinute()
    ->name('delete_expired_client_offers')
    ->withoutOverlapping();
