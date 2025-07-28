<?php

namespace App\Http\Controllers\Clients\Offers;

use App\Http\Requests\Clients\Search\SearchRequest;
use App\Services\Clients\Offers\OfferService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OfferController
{
    public function __construct(protected OfferService $offerService){}

    public function show($id): JsonResponse
    {
        return $this->offerService->show($id);
    }

    public function showUserOffer($id): JsonResponse
    {
        return $this->offerService->showUserOffer($id);
    }

    public function bookOffer($id): JsonResponse
    {
        return $this->offerService->bookOffer($id);
    }

    public function userOffers(Request $request): JsonResponse
    {
        return $this->offerService->userOffers($request);
    }

    public function indexOffers(SearchRequest $request): JsonResponse
    {
        return $this->offerService->indexOffers($request);
    }


}
