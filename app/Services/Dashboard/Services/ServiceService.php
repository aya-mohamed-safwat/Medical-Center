<?php

namespace App\Services\Dashboard\Services;

use App\Http\Resources\Dashboard\Services\ServiceResource;
use App\Jobs\Translation;
use App\Models\Service;
use App\Services\BaseServices\BaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use function App\Helpers\json;

class ServiceService extends BaseService
{
    protected $model    = Service::class;
    protected $resource = ServiceResource::class;

    public function index($request): JsonResponse
    {
        $serviceQuery =Service::query();
        $service = $serviceQuery
            ->with(['discount'])
            ->when($request->filled('active'), function ($query) use ($request) {
                $query->active($request->active);
            })
            ->latest()
            ->paginate();
        return json(__('response.success'),__('response.index'),ServiceResource::collection($service)->response()->getData(),200);
    }

    public function show($id): JsonResponse
    {
       $serviceQuery =Service::query();
       $service = $serviceQuery
           ->with(['discount'])
           ->findOrFail($id);
        return json(__('response.success'),__('response.show'),new ServiceResource($service),200);
    }

    public function handleStore(array $data)
    {
        $serviceData = Arr::only($data, ['duration_time', 'speciality_id' , 'price']);
        $fileData    = Arr::only($data , ['file' , 'file_type']);
        $service     = Service::create($serviceData);

        Translation::dispatchSync($service->id ,Service::class, ['translations' => $data['translations']]);
        $this->relation($service, $data);
        $this->image($service, $fileData);
        return $service->refresh();
    }

    public function handleUpdate( $id , array $data)
   {
        $service     = Service::findOrFail($id);
        $serviceDate = Arr::only($data, ['duration_time', 'speciality_id'  ,'price', 'is_active',]);

        if(isset($data['translations']))
        {
            Translation::dispatchSync($service->id ,Service::class, ['translations' => $data['translations']]);
        }
        $this->relation($service, $data);
        $service->update($serviceDate);
        return $service;
   }

    public function handleDelete($id): void
   {
       $service = Service::findOrFail($id);
       $service->offers()->detach();
       $service->delete();
   }

    private function relation(Service $service, array $data): void
    {
        if (!empty($data['doctor_id'])) {
            $service->doctor()->sync($data['doctor_id']);
        }
    }

    private function image(Service $service, array $data): void
    {
        if (!empty($data['file']))
        {
            $this->createFile($service, $data);
        }
    }
}
