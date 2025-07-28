<?php

use App\Http\Controllers\DashBoard\Active\ActiveController;
use App\Http\Controllers\DashBoard\Admin\Auth\AuthController;
use App\Http\Controllers\DashBoard\Admin\Profiles\ProfileController;
use App\Http\Controllers\DashBoard\Appointments\AppointmentController;
use App\Http\Controllers\DashBoard\Attachments\AttachmentController;
use App\Http\Controllers\DashBoard\ClientProfiles\ClientProfileController;
use App\Http\Controllers\DashBoard\CommentStars\CommentController;
use App\Http\Controllers\DashBoard\Discounts\DiscountController;
use App\Http\Controllers\DashBoard\DoctorProfiles\DoctorController;
use App\Http\Controllers\DashBoard\Notifications\NotificationController;
use App\Http\Controllers\DashBoard\Notifications\NotifyUsers\NotifyUserController;
use App\Http\Controllers\DashBoard\Offers\OfferController;
use App\Http\Controllers\DashBoard\Reports\ReportController;
use App\Http\Controllers\DashBoard\Roles\RoleController;
use App\Http\Controllers\DashBoard\Services\ServiceController;
use App\Http\Controllers\DashBoard\Schedules\ScheduleController;
use App\Http\Controllers\DashBoard\Settings\SettingController;
use App\Http\Controllers\DashBoard\Sliders\SliderController;
use App\Http\Controllers\DashBoard\Specialties\SpecialtyController;
use App\Http\Controllers\DashBoard\StaticPages\StaticPageController;
use App\Http\Controllers\DashBoard\Users\UserController;
use App\Http\Middleware\Language;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', "login");
    Route::post('/logout', "logout");
})->middleware(Language::class);

Route::middleware(['auth:api' , Language::class])->group(function () {

    Route::controller(ProfileController::class)->prefix('/profile')->group(function () {
        Route::get('/{id}', "show");
        Route::put('update/{id}', "update");
        Route::put('/changePassword', "changePassword");
    });

    Route::controller(NotifyUserController::class)->group(function () {
        Route::post('/notifyUser', "notifyUser");
    });

    Route::controller(ActiveController::class)->group(function () {
        Route::post('/active', "toggle");
    });

    Route::apiResource('setting', SettingController::class)->only(['update']);

    Route::apiResource('role', RoleController::class);

    Route::controller(RoleController::class)->group(function () {
        Route::put('/role/updatePermissions/{roleId}', "updatePermissions");
    });

    Route::apiResource('user', UserController::class);

    Route::apiResource('doctor', DoctorController::class);

    Route::apiResource('clients',ClientProfileController::class);

    Route::apiResource('specialty', SpecialtyController::class);

    Route::apiResource('service', ServiceController::class);

    Route::apiResource('offer', OfferController::class);

    Route::apiResource('schedule', ScheduleController::class);

    Route::apiResource('discount', DiscountController::class);

    Route::apiResource('slider', SliderController::class);

    Route::apiResource('file', AttachmentController::class);

    Route::apiResource('report', ReportController::class)->only(['index', 'store' ,'destroy']);

    Route::apiResource('staticPage', StaticPageController::class);

    Route::apiResource('appointment', AppointmentController::class)->only(['index', 'update' , 'show']);

    Route::apiResource('comment', CommentController::class)->only(['store' , 'update' , 'destroy']);

    Route::controller(CommentController::class)->prefix('/comment')->group(function () {
        Route::get('/doctor/{doctorId}', "doctorComments");
        Route::get('/client/{clientId}', "clientComments");
    });

    Route::controller(ScheduleController::class)->prefix('/schedules')->group(function () {
        Route::get('/availableTimes', "availableTimes");
    });

    Route::controller(NotificationController::class)->prefix('notify')->group(function ()
    {
        Route::get('/index', "index");
        Route::get('/unreadNotification', "unreadNotification");
        Route::get('/markAsRead/{notifyId}', "markAsRead");
        Route::get('/markAllAsRead', "markAllAsRead");
        Route::delete('/destroyOne/{$notifyId}', "destroyOne");
        Route::delete('/destroyAll', "destroyAll");

    });

});






