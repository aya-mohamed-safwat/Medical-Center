<?php

namespace App\Services\Dashboard\Discounts;

use App\Http\Resources\Dashboard\Discounts\DiscountDetailsResource;
use App\Jobs\Translation;
use App\Models\Discount;
use App\Models\User;
use App\Services\BaseServices\BaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use function App\Helpers\json;

class DiscountService extends BaseService
{
    protected $model = Discount::class;
    protected $resource = DiscountDetailsResource::class;

    public function show($id): JsonResponse
    {
        $discountQuery = Discount::query();
        $discounts = $discountQuery
            ->with(['service' , 'service.doctor'])
            ->findOrFail($id);
        return json(__('response.success'),__('response.index'),new DiscountDetailsResource($discounts),200);
    }

    public function handleStore(array $data)
    {
        $discountData = Arr::only($data, ['service_id','discount_type','discount_value', 'start_time','end_time']);
        $fileData     = Arr::only($data, ['file', 'file_type']);
        $discount     = Discount::create($discountData);

        Translation::dispatchSync($discount->id ,Discount::class, ['translations' => $data['translations']]);
        $this->image($discount, $fileData);
        return $discount->refresh();
    }

    public function handleUpdate($id, array $data)
    {
        $discount     = Discount::findOrFail($id);
        $discountData = Arr::only($data,['service_id','discount_type','discount_value','start_time','end_time' , 'is_active']);

        $discount->update($discountData);
        if(isset($data['translations'])) {
            Translation::dispatchSync($discount->id, Discount::class, ['translations' => $data['translations']]);
        }
        return $discount;
    }

    private function image(Discount $discount, array $data): void
    {
        if (!empty($data['file']))
        {
            $this->createFile($discount, $data);
        }
    }

}
