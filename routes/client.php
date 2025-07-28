<?php

use App\Http\Controllers\Clients\Appointments\AppointmentController;
use App\Http\Controllers\Clients\Auth\AuthController;
use App\Http\Controllers\Clients\CommentStars\CommentStarController;
use App\Http\Controllers\Clients\Doctors\DoctorController;
use App\Http\Controllers\Clients\Favorites\FavoriteController;
use App\Http\Controllers\Clients\Files\FileController;
use App\Http\Controllers\Clients\Home\HomeController;
use App\Http\Controllers\Clients\Notifications\NotificationController;
use App\Http\Controllers\Clients\Offers\OfferController;
use App\Http\Controllers\Clients\Payments\PaymentController;
use App\Http\Controllers\Clients\Profiles\ProfileController;
use App\Http\Controllers\Clients\Reports\ReportController;
use App\Http\Controllers\Clients\SearchHistories\SearchController;
use App\Http\Controllers\Clients\Specialities\SpecialityController;
use App\Http\Middleware\Language;
use Illuminate\Support\Facades\Route;

Route::prefix('client')->group(function () {

    Route::controller(AuthController::class)->group(function () {
    Route::post('/register', "register");
    Route::post('/confirmOtp', "confirmOtp");
    Route::post('/resendOtp', "resendOtp");
    Route::post('/forgetPassword', "forgetPassword");
    Route::post('/resetPassword', "resetPassword");
    Route::post('/login', "login");
    Route::post('/logout', "logout");
})->middleware(Language::class);

    Route::middleware(['auth:api' , Language::class])->group(function () {

    Route::controller(ProfileController::class)->prefix('profile')->group(function () {
        Route::post('/changePassword', "changePassword");
        Route::post('/changePhone', "changePhone");
        Route::post('/confirmPhoneOtp', "confirmPhoneOtp");
    });

    Route::apiResource('profile', ProfileController::class)->only(['show','update','destroy']);

    Route::apiResource('doctor', DoctorController::class)->only(['index','show']);

    Route::apiResource('favorite', FavoriteController::class)->only(['index' , 'store' , 'destroy']);

    Route::apiResource('comment', CommentStarController::class)->only([ 'store' , 'update' , 'destroy']);

    Route::apiResource('appointment', AppointmentController::class);

    Route::apiResource('file', FileController::class);

    Route::controller(FileController::class)->group(function ()
    {
        Route::get('/profileImage', "getImage");
    });

    Route::controller(CommentStarController::class)->group(function ()
    {
        Route::get('/comment/doctor/{id}', "index");
    });

    Route::controller(SpecialityController::class)->group(function ()
    {
        Route::get('/speciality/search', "search");
        Route::get('/speciality/index', "index");
        Route::get('/speciality/specialityDoctors', "specialityDoctors");
    });

    Route::controller(SearchController::class)->group(function ()
    {
        Route::get('/search/getHistory', "getHistory");
        Route::delete('/search/deleteAll', "deleteAll");
    });

    Route::controller(HomeController::class)->group(function ()
    {
        Route::get('/home', "home");
    });

    Route::controller(AppointmentController::class)->group(function ()
    {
        Route::put('/appointment/cancel/{id}', "cancel");
    });

    Route::controller(OfferController::class)->prefix('offer')->group(function ()
    {

        Route::post('/bookOffer/{id}', "bookOffer");
        Route::get('/show/{id}', "show");
        Route::get('/showUserOffer/{id}', "showUserOffer");
        Route::get('/userOffers', "userOffers");
        Route::get('/indexOffers', "indexOffers");
    });

    Route::controller(NotificationController::class)->prefix('notify')->group(function ()
        {
            Route::get('/index', "index");
            Route::get('/unreadNotification', "unreadNotification");
            Route::get('/markAsRead/{notifyId}', "markAsRead");
            Route::get('/markAllAsRead', "markAllAsRead");
            Route::post('/toggle', "toggle");
        });

    Route::apiResource('report', ReportController::class)->only([ 'index']);


    });

    Route::controller(PaymentController::class)->prefix('stripe')->group(function ()
    {
        Route::post('/pay', "pay");
        Route::get('/webhook', "webhook");
        Route::get('/success', "success");
        Route::get('/cancel', "cancel");

    });

});






