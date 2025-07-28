<?php

namespace App\Http\Controllers\DashBoard\Attachments;

use App\Http\Middleware\CheckPermission;
use App\Http\Requests\Clients\Files\FileRequest;
use App\Http\Requests\dashboard\Attachments\FileStoreRequest;
use Illuminate\Routing\Controller;
use App\Services\Dashboard\Attachments\AttachmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function __construct(protected AttachmentService $attachmentService)
    {
        $this->middleware(CheckPermission::class .':create-files')->only(['store','update']);
        $this->middleware(CheckPermission::class .':delete-files')->only(['destroy']);
        $this->middleware(CheckPermission::class .':view-files')->only(['show' , 'index']);
    }

    public function index(Request $request): JsonResponse
    {
        return $this->attachmentService->index($request);
    }

    public function show($id): JsonResponse
    {
        return $this->attachmentService->show($id);
    }

    public function store(FileStoreRequest $request): JsonResponse
    {

        return $this->attachmentService->store($request->validated());
    }

    public function update($id , FileRequest $request): JsonResponse
    {
        return $this->attachmentService->update($id , $request->validated());
    }

    public function destroy($id): JsonResponse
    {
        return $this->attachmentService->destroy($id);
    }
}
