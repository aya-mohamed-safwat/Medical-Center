<?php

namespace App\Services\Clients\Home;

use App\Http\Resources\Clients\Doctors\DoctorProfileResource;
use App\Http\Resources\Dashboard\Offers\OfferDetailsResource;
use App\Http\Resources\Dashboard\Offers\OfferResource;
use App\Http\Resources\Dashboard\Sliders\SliderResource;
use App\Http\Resources\Dashboard\Specialties\SpecialtyResource;
use App\Models\Discount;
use App\Models\Offer;
use App\Models\Slider;
use App\Models\Speciality;
use App\Models\User;
use function App\Helpers\json;

class HomeService
{
    public function home()
    {
        $sliderData = Slider::with('discount' , 'discount.attachment')
            ->where('type' , 'spalsh')
            ->active(1)
            ->latest()
            ->take(5)
            ->get();

        $specialityData = Speciality::with('attachment')
            ->whereNull('parent_id')
            ->active(1)
            ->latest()
            ->take(7)
            ->get();

        $doctorData = User::where('role_id', 2)
            ->with(['doctorProfile' , 'doctorProfile.specialities' ,'doctorProfile.attachment'])
            ->active(1)
            ->latest()
            ->take(5)
            ->get();

        $offerData = Offer::latest()->active(1)->take(5)->get();

        $slider = SliderResource::collection($sliderData);
        $speciality = SpecialtyResource::collection($specialityData);
        $doctor = DoctorProfileResource::collection($doctorData);
        $offer = OfferResource::collection($offerData);

        return json(__('response.success'),__('response.index'),
            ['sliders' => $slider
            ,'specialities' => $speciality
            ,'doctors' => $doctor
            ,'offers' => $offer]
            ,200);

    }
}
