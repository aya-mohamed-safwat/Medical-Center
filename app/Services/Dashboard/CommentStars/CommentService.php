<?php

namespace App\Services\Dashboard\CommentStars;

use App\Http\Resources\Clients\CommentStars\CommentStarResource;
use App\Models\CommentStar;
use App\Services\BaseServices\BaseService;
use Illuminate\Http\JsonResponse;
use function App\Helpers\json;

class CommentService extends BaseService
{
    protected $model = CommentStar::class;
    protected $resource = CommentStarResource::class;

    public function clientComments($request): JsonResponse
    {
        $commentQuery = CommentStar::query();
        $commentsData = $commentQuery
            ->with('doctor')
            ->where('client_id' , $request)
            ->latest()
            ->paginate();
        CommentStarResource::wrap('commentsData');
        return json(__('response.success'),__('response.index'),CommentStarResource::collection($commentsData)->response()->getData(),200);
    }
}
