<?php

namespace App\Services\Clients\SearchHistories;

use App\Http\Resources\Clients\SearchHistories\SearchResource;
use App\Models\SearchHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use function App\Helpers\json;

class SearchService
{
    public function getHistory(): JsonResponse
    {
        $searchQuery = SearchHistory::query();
        $searchData = $searchQuery
            ->where('user_id' , auth()->id())
            ->latest()
            ->take(10)
            ->get();
        SearchResource::wrap('searchData');
        return json(__('response.success'),__('response.index'),SearchResource::collection($searchData)->response()->getData(),200);
    }

    public function deleteAll(): JsonResponse
    {
        try{
            $user = auth()->user();
            $user->histories()->delete();
            return json(__('response.success'),__('response.done.delete'),'',200);
        }catch (\Exception $exception){
            Log::info(json_encode($exception->getMessage()));
            return json(__('response.failed'), __('response.error.delete'), '', 404);
        }
    }
}
