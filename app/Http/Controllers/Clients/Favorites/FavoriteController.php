<?php

namespace App\Http\Controllers\Clients\Favorites;

use App\Http\Requests\Clients\Favorites\FavoriteStoreRequest;
use App\Services\Clients\Favorites\FavoriteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class FavoriteController
{
    public function __construct(protected FavoriteService $favoriteService){}

    public function index(): JsonResponse
    {
        return $this->favoriteService->index();
    }

    public function store(FavoriteStoreRequest $request): JsonResponse
    {
        return $this->favoriteService->store($request);
    }

    public function destroy($id): JsonResponse
    {
        return $this->favoriteService->destroy($id);
    }
}
