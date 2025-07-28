<?php

namespace App\Http\Controllers\DashBoard\Discounts;

use App\Http\Middleware\CheckPermission;
use Illuminate\Routing\Controller;
use App\Http\Requests\dashboard\Discounts\DiscountStoreRequest;
use App\Http\Requests\dashboard\Discounts\DiscountUpdateRequest;
use App\Services\Dashboard\Discounts\DiscountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function __construct(protected DiscountService $discountService)
    {
        $this->middleware(CheckPermission::class .':create-discounts')->only(['store']);
        $this->middleware(CheckPermission::class .':update-discounts')->only(['update']);
        $this->middleware(CheckPermission::class .':delete-discounts')->only(['destroy']);
        $this->middleware(CheckPermission::class .':view-discounts')->only(['show' , 'index']);
    }

    public function index(Request $request): JsonResponse
    {
        return $this->discountService->index($request);
    }

    public function show($id): JsonResponse
    {
        return $this->discountService->show($id);
    }

    public function store(DiscountStoreRequest $request): JsonResponse
    {
        return $this->discountService->store($request->validated());
    }

    public function update(DiscountUpdateRequest $request, $id): JsonResponse
    {
        return $this->discountService->update($id , $request->validated());
    }

    public function destroy($id): JsonResponse
    {
        return $this->discountService->destroy($id);
    }
}
