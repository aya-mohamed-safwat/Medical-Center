<?php

namespace App\Services\Clients\CommentStars;

use App\Http\Resources\Clients\CommentStars\CommentStarResource;
use App\Models\CommentStar;
use App\Services\BaseServices\BaseService;
use Illuminate\Http\JsonResponse;
use function App\Helpers\json;

class CommentStarService extends BaseService
{
    protected $model = CommentStar::class;
    protected $resource = CommentStarResource::class;
    protected $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function index($request): JsonResponse
    {
        $commentQuery = CommentStar::query();
        $commentsData = $commentQuery
            ->with(['client'])
            ->where('doctor_id' , $request)
            ->latest()
            ->paginate();
        CommentStarResource::wrap('commentsData');
        return json(__('response.success'),__('response.index'),CommentStarResource::collection($commentsData)->response()->getData(),200);
    }

    public function handleStore(array $data)
    {
        return  CommentStar::create([
            'doctor_id' => $data['doctor_id'],
            'client_id' => $this->user->id,
            'comment' => $data['comment'],
            'stars' => $data['star'],
        ]);
    }

    public function handleUpdate($id, array $data)
    {
        $comment = CommentStar::where('id' ,$id)
            ->where('client_id' , $this->user->id)
            ->first();
        $comment->update($data);
        return $comment;
    }

}
