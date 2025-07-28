<?php

namespace App\Services\Clients\Doctors;

use App\Http\Resources\Clients\Doctors\DoctorDetailsResource;
use App\Http\Resources\Clients\Doctors\DoctorProfileResource;
use App\Http\Resources\Clients\Doctors\DoctorProResource;
use App\Models\DoctorProfile;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use function App\Helpers\json;

class DoctorService
{
    public function index($request): JsonResponse
    {
        $doctorsData = QueryBuilder::for(User::class)
            ->where('role_id', 2)
            ->when($request->filled('active'), function ($query) use ($request) {
                $query->active(1);
            })
            ->with(['doctorProfile.specialities' ,'doctorProfile.attachment'])
            ->withCount('commentStars as reviews_count')
            ->withAvg('commentStars as average_rating', 'stars')

            ->allowedFilters(['name',
                AllowedFilter::callback('price', function ($query, $value) {
                    [$min, $max] = explode('-', $value);
                $query->whereHas('doctorProfile', function ($q) use ($min ,$max) {
                    $q->whereBetween('price', [(float) $min, (float) $max]);
                });
            }),
                AllowedFilter::callback('speciality', function ($query, $value) {
                    $query->whereHas('doctorProfile.specialities', function ($q) use ($value) {
                        $q->whereTranslationLike('name', "%{$value}%");});
                }),
                AllowedFilter::callback('gender', function ($query, $value) {
                    $query->whereHas('doctorProfile.translation', function ($q) use ($value) {
                        $q->where('gender', $value);});
                })
            ])
            ->allowedSorts(['average_rating' ,
                AllowedSort::callback('price', function ($query, $descending) {
                    $query->join('doctor_profiles', 'users.id', '=', 'doctor_profiles.user_id')
                        ->orderBy('doctor_profiles.price', $descending ? 'desc' : 'asc')
                        ->select('users.*');
                })
            ])
            ->defaultSort('name')
            ->paginate();
        return json(__('response.success'),__('response.index'),DoctorProfileResource::collection($doctorsData)->response()->getData(),200);
    }

    public function show($id): JsonResponse
    {
        $doctors = User::where('role_id' , 2)
            ->with(['doctorProfile.translation', 'doctorProfile.specialities' ,
                'doctorProfile.attachment' ,'doctorProfile.certificates' , 'commentStars' , 'doctorProfile.schedules'])
            ->withCount('commentStars as reviews_count')
            ->withAvg('commentStars as average_rating', 'stars')
            ->findOrFail($id);
        return json(__('response.success'), __('response.show'), new DoctorDetailsResource($doctors), 200);
    }
}
