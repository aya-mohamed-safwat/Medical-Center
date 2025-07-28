<?php

namespace App\Providers;

use App\Services\Clients\Appointments\AppointmentService as ClientAppointmentService;
use App\Services\Clients\Auth\AuthService as ClientAuthService;
use App\Services\Clients\Auth\OtpService;
use App\Services\Clients\CommentStars\CommentStarService as ClientCommentService;
use App\Services\Clients\Doctors\DoctorService as ClientDoctorService;
use App\Services\Clients\Favorites\FavoriteService;
use App\Services\Clients\Fcm\FcmService;
use App\Services\Clients\Home\HomeService;
use App\Services\Clients\Offers\OfferService as ClientOfferService;
use App\Services\Clients\Profiles\ProfileService as ClientProfile;
use App\Services\Clients\SearchHistories\SearchService;
use App\Services\Clients\Specialities\SpecialityService as ClientSpecialityService;
use App\Services\Dashboard\Active\ActiveService;
use App\Services\Dashboard\Admins\Auth\AuthService;
use App\Services\Dashboard\Admins\Profiles\ProfileService;
use App\Services\Dashboard\Appointments\AppointmentService;
use App\Services\Dashboard\Attachments\AttachmentService;
use App\Services\Dashboard\ClientProfiles\ClientProfileService;
use App\Services\Dashboard\CommentStars\CommentService;
use App\Services\Dashboard\Discounts\DiscountService;
use App\Services\Dashboard\DoctorProfiles\DoctorService;
use App\Services\Dashboard\Notifications\NotificationService;
use App\Services\Dashboard\Notifications\NotifyUserService;
use App\Services\Dashboard\Offers\OfferService;
use App\Services\Dashboard\Roles\RoleService;
use App\Services\Dashboard\Schedules\SchedulesService;
use App\Services\Dashboard\Services\ServiceService;
use App\Services\Dashboard\Settings\SettingService;
use App\Services\Dashboard\Sliders\SliderService;
use App\Services\Dashboard\Specialties\SpecialtyService;
use App\Services\Dashboard\StaticPages\StaticPageService;
use App\Services\Dashboard\Users\UserService;
use App\Services\Strategies\StripeService;
use Illuminate\Support\ServiceProvider;

class CustomServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Client Services
        $this->app->singleton(ClientAppointmentService::class, function ($app) {
            return new ClientAppointmentService();
        });
        $this->app->singleton(OtpService::class, function ($app) {
            return new OtpService();
        });
        $this->app->singleton(ClientAuthService::class, function ($app) {
            $otpService = $app->make(OtpService::class);
            return new ClientAuthService($otpService);
        });
        $this->app->singleton(ClientCommentService::class, function ($app) {
           return new ClientCommentService();
       });
        $this->app->singleton(ClientDoctorService::class, function ($app) {
           return new ClientDoctorService();
       });
        $this->app->singleton(FavoriteService::class, function ($app) {
           return new FavoriteService();
       });
        $this->app->singleton(FcmService::class, function ($app) {
            return new FcmService();
        });
        $this->app->singleton(HomeService::class, function ($app) {
            return new HomeService();
        });
        $this->app->singleton(ClientOfferService::class, function ($app) {
            return new ClientOfferService();
        });
        $this->app->singleton(ClientProfile::class, function ($app) {
            $otpService = $app->make(OtpService::class);
            return new ClientProfile($otpService);
        });
        $this->app->singleton(SearchService::class, function ($app) {
            return new SearchService();
        });
        $this->app->singleton(ClientSpecialityService::class, function ($app) {
            return new ClientSpecialityService();
        });
        $this->app->singleton(StripeService::class, function ($app) {
            return new StripeService();
        });

        //Dashboard Services
        $this->app->singleton(ActiveService::class, function ($app) {
            return new ActiveService();
        });
        $this->app->singleton(AuthService::class, function ($app) {
            return new AuthService();
        });
        $this->app->singleton(ProfileService::class, function ($app) {
            return new ProfileService();
        });
        $this->app->singleton(AppointmentService::class, function ($app) {
            return new AppointmentService();
        });
        $this->app->singleton(AttachmentService::class, function ($app) {
            return new AttachmentService();
        });
        $this->app->singleton(ClientProfileService::class, function ($app) {
            return new ClientProfileService();
        });
        $this->app->singleton(CommentService::class, function ($app) {
            return new CommentService();
        });
        $this->app->singleton(DiscountService::class, function ($app) {
            return new DiscountService();
        });
        $this->app->singleton(DoctorService::class, function ($app) {
            return new DoctorService();
        });
        $this->app->singleton(NotificationService::class, function ($app) {
            return new NotificationService();
        });
        $this->app->singleton(NotifyUserService::class, function ($app) {
            return new NotifyUserService();
        });
        $this->app->singleton(OfferService::class, function ($app) {
            return new OfferService();
        });
        $this->app->singleton(RoleService::class, function ($app) {
            return new RoleService();
        });
        $this->app->singleton(SchedulesService::class, function ($app) {
            return new SchedulesService();
        });
        $this->app->singleton(ServiceService::class, function ($app) {
            return new ServiceService();
        });
        $this->app->singleton(SettingService::class, function ($app) {
            return new SettingService();
        });
        $this->app->singleton(SliderService::class, function ($app) {
            return new SliderService();
        });
        $this->app->singleton(SpecialtyService::class, function ($app) {
            return new SpecialtyService();
        });
        $this->app->singleton(StaticPageService::class, function ($app) {
            return new StaticPageService();
        });
        $this->app->singleton(UserService::class, function ($app) {
            return new UserService();
        });
    }

    public function provides(): array
    {
        return [
            ClientAppointmentService::class,
            OtpService::class,
            ClientAuthService::class,
            ClientCommentService::class,
            ClientDoctorService::class,
            FavoriteService::class,
            FcmService::class,
            HomeService::class,
            ClientOfferService::class,
            ClientProfileService::class,
            SearchService::class,
            ClientSpecialityService::class,
            StripeService::class,

            ActiveService::class,
            AuthService::class,
            ProfileService::class,
            AppointmentService::class,
            AttachmentService::class,
            ClientProfileService::class,
            CommentService::class,
            DiscountService::class,
            DoctorService::class,
            NotificationService::class,
            NotifyUserService::class,
            OfferService::class,
            RoleService::class,
            SchedulesService::class,
            ServiceService::class,
            SettingService::class,
            SliderService::class,
            SpecialtyService::class,
            StaticPageService::class,
            UserService::class,
        ];
    }

    public function boot(): void
    {

    }
}
