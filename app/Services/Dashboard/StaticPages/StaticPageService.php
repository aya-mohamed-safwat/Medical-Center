<?php

namespace App\Services\Dashboard\StaticPages;

use App\Http\Resources\Dashboard\StaticPages\StaticPageResource;
use App\Jobs\Translation;
use App\Models\StaticPage;
use App\Services\BaseServices\BaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use function App\Helpers\json;

class StaticPageService extends BaseService
{
    protected $model = StaticPage::class;
    protected $resource = StaticPageResource::class;

    public function showData($slug,Request $request): JsonResponse
    {
        $page = StaticPage::where('slug', $slug)
            ->when($request->filled('active'), function ($query) use ($request) {
                $query->active($request->is_active);
            })->first();

        return json(__('response.success'),__('response.show'),new StaticPageResource($page),200);
    }

    public function handleStore(array $data)
    {
        $fileData = Arr::only($data , ['file' , 'file_type']);

        if(empty($data['slug'])) {
                $data['slug'] = Str::slug($data['translations']['en']['title']);
           }

        $page = StaticPage::create(['slug' => $data['slug']]);
        if (!empty($fileData['file']))
        {
            $this->createFile($page, $fileData);
        }
        Translation::dispatchSync($page->id ,StaticPage::class, ['translations' => $data['translations']]);
        return $page->refresh();
    }

    public function handleUpdate($id, array $data)
    {
        $page = StaticPage::findOrFail($id);
        if(empty($data['slug'])) {
            $data['slug'] = Str::slug($data['translations']['en']['title']);
        }

        if(isset($data['translations'])) {
            Translation::dispatchSync($page->id ,StaticPage::class, ['translations' => $data['translations']]);
        }
        $page->update(['slug' => $data['slug']]);
        return $page->refresh();
    }

}
