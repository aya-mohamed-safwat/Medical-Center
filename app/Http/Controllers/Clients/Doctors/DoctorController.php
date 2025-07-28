<?php

namespace App\Http\Controllers\Clients\Doctors;

use App\Services\Clients\Doctors\DoctorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorController
{
    public function __construct(protected DoctorService $doctorService){}

    public function index(Request $request): JsonResponse
    {
        return $this->doctorService->index($request);
    }

    public function show($id): JsonResponse
    {
        return $this->doctorService->show($id);
    }

}
