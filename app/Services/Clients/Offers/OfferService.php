<?php

namespace App\Services\Clients\Offers;

use App\Enums\BookingStatus;
use App\Http\Resources\Clients\ClientOffers\ClientOfferDetailsResource;
use App\Http\Resources\Clients\ClientOffers\ClientOfferResource;
use App\Http\Resources\Dashboard\Offers\OfferDetailsResource;
use App\Http\Resources\Dashboard\Offers\OfferResource;
use App\Models\ClientOffer;
use App\Models\Offer;
use Illuminate\Http\JsonResponse;
use function App\Helpers\json;

class OfferService
{
    protected $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function show($id): JsonResponse
    {
        $offer = Offer::with('service' , 'speciality' , 'attachment')->findOrFail($id);
        return json(__('response.success'),__('response.show'),OfferDetailsResource::collection($offer),200);
    }

    public function showUserOffer($id): JsonResponse
    {
        $offer = ClientOffer::with('offer.attachment')
            ->where('client_profile_id',$this->user->clientProfile->id)
            ->findOrFail($id);
        return json(__('response.success') , __('response.show') ,new ClientOfferDetailsResource($offer),200);
    }

    public function bookOffer($offerId): JsonResponse
    {
        $clientOffers = $this->user->clientprofile?->clientOffers()
            ->where('offer_id',$offerId)
            ->get();

        $hasActiveOffer = $clientOffers->contains(fn($offer) => $offer->remaining_sessions > 0);

        if($hasActiveOffer){
            return json(__('response.failed'), __('response.offer.not_added'), '',403);
        }
        $totalClientOffers = $clientOffers->count();
        $offerData = Offer::with('attachment')->findOrFail($offerId);

        if($offerData->number_of_reservation < $offerData->total_reservation &&
            $totalClientOffers < $offerData->max_reservation_per_user)
        {
            ClientOffer::create([
                'offer_id'           => $offerId,
                'client_profile_id'  => $this->user->clientProfile->id,
                'remaining_sessions' => $offerData->sessions_number,
            ]);
            $offerData->increment('number_of_reservation');
            return json(__('response.success') , __('response.offer.add') ,new OfferDetailsResource($offerData),200);
        }
        return json(__('response.failed') , __('response.offer.max_reservation') ,'' ,403);
    }

    public function userOffers($request): JsonResponse
    {
        $offers = ClientOffer::where('client_profile_id',$this->user->clientProfile->id)
            ->when($request->filled('status'),function ($query) use ($request){
                $query->where('status' , $request->status);
            })
            ->with('offer.attachment')
            ->latest()
            ->paginate();

        return json(__('response.success') , __('response.show') ,ClientOfferResource::collection($offers)->response()->getData(),200);
    }

    public function indexOffers($request): JsonResponse
    {
        $offers = Offer::whereHas('speciality', function ($query) use ($request) {
            $query->whereTranslationLike('name', '%' . $request->name . '%');
        })->with('attachment')->latest()->paginate();
        return json('success' , 'get data successfully' ,OfferDetailsResource::collection($offers)->response()->getData(),200);
    }
}
