<?php

namespace App\Http\Controllers\Clients\SearchHistories;

use App\Services\Clients\SearchHistories\SearchService;
use Illuminate\Http\JsonResponse;

class SearchController
{
    public function __construct(protected SearchService $searchService){}

    public function getHistory(): JsonResponse
    {
        return $this->searchService->getHistory();
    }

    public function deleteAll(): JsonResponse
    {
        return $this->searchService->deleteAll();
    }
}
