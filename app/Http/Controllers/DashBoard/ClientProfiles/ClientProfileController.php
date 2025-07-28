<?php

namespace App\Http\Controllers\DashBoard\ClientProfiles;

use App\Http\Middleware\CheckPermission;
use Illuminate\Routing\Controller;
use App\Http\Requests\Clients\Profiles\ProfileUpdateRequest;
use App\Services\Dashboard\ClientProfiles\ClientProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientProfileController extends Controller
{
    public function __construct(protected ClientProfileService $Service)
    {
        $this->middleware(CheckPermission::class .':update-client')->only(['update']);
        $this->middleware(CheckPermission::class .':delete-client')->only(['destroy']);
        $this->middleware(CheckPermission::class .':view-client')->only(['index' , 'show']);
    }

    public function index(Request $request): JsonResponse
    {
        return $this->Service->index($request);
    }

    public function show($id): JsonResponse
    {
        return $this->Service->show($id);
    }

    public function update($id , ProfileUpdateRequest $request): JsonResponse
    {
        return $this->Service->update($id , $request->validated());
    }

    public function destroy($id): JsonResponse
    {
        return $this->Service->destroy($id);
    }
}
