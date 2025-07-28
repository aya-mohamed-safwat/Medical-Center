<?php

namespace App\Services\Dashboard\Specialties;

use App\Http\Resources\Dashboard\Specialties\SpecialtyResource;
use App\Jobs\Translation;
use App\Models\Offer;
use App\Models\Speciality;
use App\Services\BaseServices\BaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use function App\Helpers\json;

class SpecialtyService extends BaseService
{
    protected $model = Speciality::class;
    protected $resource = SpecialtyResource::class;

    public function show($id): JsonResponse
    {
        $specialityQuery = Speciality::query();
        $specialities = $specialityQuery
            ->with(['subSpecialty'])
            ->findOrFail($id);
        return json(__('response.success'),__('response.show'),new SpecialtyResource($specialities),200);
    }

    public function handleStore(array $data)
    {
        $specialityData = Arr::only($data , ['parent_id']);
        $fileData       = Arr::only($data , ['file' , 'file_type']);

        $speciality = Speciality::create($specialityData);
        $this->image($speciality, $fileData);

        Translation::dispatchSync($speciality->id ,Speciality::class, ['translations' => $data['translations']]);
        return $speciality->refresh();
    }

    public function handleUpdate($id, array $data)
    {
        $speciality = Speciality::findOrFail($id);
        if(isset($data['translations'])) {
            Translation::dispatchSync($speciality->id, Speciality::class, ['translations' => $data['translations']]);
        }
        $speciality->update(['parent_id' => $data['parent_id']]);
        return $speciality;
    }

    private function image(Speciality $speciality, array $data): void
    {
        if (!empty($data['file']))
        {
            $this->createFile($speciality, $data);
        }
    }

}
