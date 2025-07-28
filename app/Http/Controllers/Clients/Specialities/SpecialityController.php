<?php

namespace App\Http\Controllers\Clients\Specialities;

use App\Http\Requests\Clients\Search\SearchRequest;
use App\Http\Requests\dashboard\Specialties\SpecialityIndexRequest;
use App\Models\Speciality;
use App\Services\Clients\Specialities\SpecialityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SpecialityController
{
    public function __construct(protected SpecialityService $service){}

    public function index(SpecialityIndexRequest $request): JsonResponse
    {
        return $this->service->index($request);
    }

    public function search(SearchRequest $request): JsonResponse
    {
        return $this->service->search($request);
    }

    public function specialityDoctors(Request $request): JsonResponse
    {
        return $this->service->specialityDoctors($request);
    }
}
