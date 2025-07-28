<?php

namespace App\Http\Controllers\DashBoard\CommentStars;

use App\Http\Middleware\CheckPermission;
use Illuminate\Routing\Controller;
use App\Http\Requests\Clients\CommentStars\CommentStoreRequest;
use App\Http\Requests\Clients\CommentStars\CommentUpdateRequest;
use App\Services\Clients\CommentStars\CommentStarService as ClientCommentService;
use App\Services\Dashboard\CommentStars\CommentService;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    public function __construct(protected ClientCommentService $service , protected CommentService $commentService)
    {
        $this->middleware(CheckPermission::class .':create-comment')->only(['store']);
        $this->middleware(CheckPermission::class .':update-comment')->only(['update']);
        $this->middleware(CheckPermission::class .':delete-comment')->only(['destroy']);
        $this->middleware(CheckPermission::class .':view-comment')->only(['doctorComments' , 'clientComments']);
    }

    public function doctorComments($doctorId): JsonResponse
    {
        return $this->service->index($doctorId);
    }

    public function clientComments($clientId): JsonResponse
    {
        return $this->commentService->clientComments($clientId);
    }

    public function store(CommentStoreRequest $request): JsonResponse
    {
        return $this->service->store($request->validated());
    }

    public function update($id , CommentUpdateRequest $request): JsonResponse
    {
        return $this->commentService->update($id, $request->validated());
    }

    public function destroy($id): JsonResponse
    {
        return $this->commentService->destroy($id);
    }
}
