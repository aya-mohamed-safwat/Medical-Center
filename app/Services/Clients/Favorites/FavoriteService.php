<?php

namespace App\Services\Clients\Favorites;

use App\Http\Requests\Clients\Favorites\FavoriteStoreRequest;
use App\Http\Resources\Clients\Favorites\FavoriteResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use function App\Helpers\json;

class FavoriteService
{
    protected ?\Illuminate\Contracts\Auth\Authenticatable $user;

    public function __construct()
    {
        $this->user = auth('api')->user();
    }

    public function index(): JsonResponse
    {
        $favoriteData = $this->user->favouriteDoctors()
            ->with(['doctorProfile.specialities' ,'doctorProfile.attachment'])
            ->withCount('commentStars as reviews_count')
            ->withAvg('commentStars as average_rating', 'stars')
            ->latest()
            ->paginate();

        FavoriteResource::wrap('favoriteData');
        return json(__('response.success'),__('response.index'),FavoriteResource::collection($favoriteData),200);
    }

    public function store(FavoriteStoreRequest $request): JsonResponse
    {
        $doctor = User::where('role_id' , 2)->findOrFail($request->doctorId);

        if(!$this->user->favouriteDoctors()->where('doctor_id', $request->doctorId)->exists()){
            $this->user->favouriteDoctors()->attach($request->doctorId);
            return json(__('response.success'),__('response.favorite.add'),'',200);
        }
        return json(__('response.failed'),__('response.favorite.exist'),'',409);
    }

    public function destroy($id): JsonResponse
    {
        $user = auth()->user();
        $user->favouriteDoctors()->detach($id);
        return json(__('response.success'),__('response.favorite.remove'),'',200);
    }
}
