<?php

namespace App\Http\Controllers\DashBoard\Offers;

use App\Http\Middleware\CheckPermission;
use App\Http\Requests\dashboard\Offers\OfferStoreRequest;
use App\Http\Requests\dashboard\Offers\OfferUpdateRequest;
use Illuminate\Routing\Controller;
use App\Services\Dashboard\Offers\OfferService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function __construct(protected OfferService $offerService)
    {
        $this->middleware(CheckPermission::class .':create-offers')->only(['store']);
        $this->middleware(CheckPermission::class .':update-offers')->only(['update']);
        $this->middleware(CheckPermission::class .':delete-offers')->only(['destroy']);
        $this->middleware(CheckPermission::class .':view-offers')->only(['show' , 'index']);
    }

    public function index(Request $request): JsonResponse
    {
        return $this->offerService->index($request);
    }

    public function show($id): JsonResponse
    {
        return $this->offerService->show($id);
    }

    public function store(OfferStoreRequest $request): JsonResponse
    {
        return $this->offerService->store($request->validated());
    }

    public function update(OfferUpdateRequest $request, $id): JsonResponse
    {
        return $this->offerService->update($id , $request->validated());
    }

    public function destroy($id): JsonResponse
    {
        return $this->offerService->destroy($id);
    }

}
