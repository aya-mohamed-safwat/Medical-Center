<?php

namespace App\Http\Controllers\Clients\CommentStars;

use App\Http\Requests\Clients\CommentStars\CommentStoreRequest;
use App\Http\Requests\Clients\CommentStars\CommentUpdateRequest;
use App\Services\Clients\CommentStars\CommentStarService;
use Illuminate\Http\JsonResponse;

class CommentStarController
{
    public function __construct(protected CommentStarService $commentStarService){}

    public function index($id): JsonResponse
    {
        return $this->commentStarService->index($id);
    }

    public function store(CommentStoreRequest $request ): JsonResponse
    {
        return $this->commentStarService->store($request->validated());
    }

    public function update(CommentUpdateRequest $request , $id): JsonResponse
    {
        return $this->commentStarService->update($id , $request->validated());
    }

    public function destroy($id): JsonResponse
    {
        return $this->commentStarService->destroy($id);
    }
}
