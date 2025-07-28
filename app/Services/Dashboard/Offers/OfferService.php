<?php

namespace App\Services\Dashboard\Offers;

use App\Http\Resources\Dashboard\Offers\OfferDetailsResource;
use App\Http\Resources\Dashboard\Offers\OfferResource;
use App\Jobs\Translation;
use App\Models\Offer;
use App\Services\BaseServices\BaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use function App\Helpers\json;

class OfferService extends BaseService
{
    protected $model = Offer::class;
    protected $resource = OfferResource::class;

    public function show($id): JsonResponse
    {
        $offerQuery = Offer::query();
        $offers = $offerQuery
            ->with(['service' , 'speciality' , 'attachment'])
            ->findOrFail($id);
        return json(__('response.success'),__('response.show'),new OfferDetailsResource($offers),200);
    }

    public function handleStore(array $data)
    {
        $offerData = Arr::only($data, ['discount_type','discount_value','total_reservation','original_price','sessions_number', 'service_id', 'max_reservation_per_user','payment_timeout','start_time','end_time','redirect_type' ,'redirect_id','speciality_id']);
        $fileData  = Arr::only($data , ['file' , 'file_type']);

        $offer = Offer::create($offerData);
        $this->image($offer, $fileData);
        Translation::dispatchSync($offer->id ,Offer::class, ['translations' => $data['translations']]);
        return $offer->refresh();
    }

    public function handleUpdate($id, array $data)
    {
        $offer     = Offer::findOrFail($id);
        $offerData = Arr::only($data, ['discount_type','discount_value','total_reservation', 'max_reservation_per_user','sessions_number','service_id', 'payment_timeout','start_time','end_time','redirect_type' ,'redirect_id','original_price','speciality_id']);
        if(isset($data['translations'])) {
            Translation::dispatchSync($offer->id, Offer::class, ['translations' => $data['translations']]);
        }
        $offer->update($offerData);
        return $offer;
    }

    private function image(Offer $offer, array $data): void
    {
        if (!empty($data['file']))
        {
            $this->createFile($offer, $data);
        }
    }
}
