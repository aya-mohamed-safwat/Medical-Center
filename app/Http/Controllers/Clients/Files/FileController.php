<?php

namespace App\Http\Controllers\Clients\Files;

use App\Http\Requests\Clients\Files\FileRequest;
use App\Services\Clients\Files\FileService;
use App\Services\Dashboard\Attachments\AttachmentService;
use Illuminate\Http\JsonResponse;

class FileController
{
    public function __construct(protected FileService $FileService , protected AttachmentService $attachmentService){}

    public function getImage(): JsonResponse
    {
        return $this->FileService->getImage();
    }

    public function store(FileRequest $request): JsonResponse
    {
        return $this->FileService->store($request->validated());
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
