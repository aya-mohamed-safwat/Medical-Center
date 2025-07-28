<?php

namespace App\Services\Clients\Specialities;

use App\Http\Resources\Clients\Doctors\DoctorProfileResource;
use App\Http\Resources\Dashboard\Specialties\SpecialtyResource;
use App\Models\SearchHistory;
use App\Models\Speciality;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function App\Helpers\json;

class SpecialityService
{
    public function search($request): JsonResponse
    {
        $query = $request->input('name');
        $doctorsData = User::where('role_id' , 2)
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
        ->with(['doctorProfile.specialities' ,'doctorProfile.attachment'])
        ->withCount('commentStars as reviews_count')
        ->withAvg('commentStars as average_rating', 'stars')
        ->paginate();

        $specialitiesData = Speciality::whereTranslationLike('name', "%{$query}%")
            ->with(['attachment'])
            ->active(1)
            ->paginate();
        $this->storeHistory($request);
        $doctors = DoctorProfileResource::collection($doctorsData);
        $speciality = SpecialtyResource::collection($specialitiesData);

        return json(__('response.success'),__('response.index'),['doctors'=> $doctors , 'specialities' => $speciality ] ,200);
    }

    public function storeHistory($request): void
    {
        SearchHistory::create([
            'user_id' => auth()->id(),
            'search'  => $request->input('name')
        ]);
    }

    public function index($request): JsonResponse
    {
        $specialityQuery = Speciality::query();
        $specialityData = $specialityQuery
            ->with(['attachment'])
            ->active(1)
            ->when($request->filled('sub'), function ($q) use ($request) {
                $q->where('id' , $request->input('sub'))->with('subSpecialty');
            }, function ($q) {
                $q->whereNull('parent_id');
            })
            ->latest()
            ->paginate();
        SpecialtyResource::wrap('specialityData');
        return json(__('response.success'),__('response.index'),SpecialtyResource::collection($specialityData)->response()->getData(),200);
    }

    public function specialityDoctors(Request $request): JsonResponse
    {
        $specialityQuery = Speciality::query();
        $specialityData = $specialityQuery
            ->with(['attachment'])
            ->active(1)
            ->when($request->filled('sub'), function ($q) use ($request) {
                $q->where('id' , $request->input('sub'))->with(['doctors.user', 'doctors.specialities' ,'doctors.attachment']);
            }, function ($q) {
                $q->whereNull('parent_id');
            })
            ->latest()
            ->paginate();
        SpecialtyResource::wrap('specialityData');
        return json(__('response.success'),__('response.index'),SpecialtyResource::collection($specialityData)->response()->getData(),200);
    }
}
