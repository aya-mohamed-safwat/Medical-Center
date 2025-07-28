<?php

namespace App\Services\Strategies;

use App\Contracts\PaymentStrategy;
use App\Models\Offer;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Webhook;
use function App\Helpers\json;

class StripeService implements PaymentStrategy
{

    public function payment($request): JsonResponse
    {
        $offer = Offer::find($request->offerId);

        $clientOffer = $offer->clientOffers()
            ->where('client_profile_id', auth()->user()->clientProfile->id)
            ->where('is_paid' , false)
            ->first();

        if(!$clientOffer){
           return json(__('response.failed'), __('response.payment.paid_offer') , '' ,400);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'EGP',
                    'product_data' => [
                        'name' => 'offer_payment',
                    ],
                    'unit_amount' => $offer?->getDiscountedPrice($offer->original_price)*100 ?? 0,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'payment_intent_data' => [
                'metadata' => [
                    'offer_id' => $offer->id,
                    'user_id'  => auth()->user()->clientProfile->id,
                    ],
                ],
            'success_url' => url('/api/client/stripe/success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => url('/api/client/stripe/cancel'),
        ]);

        return response()->json([
            'url' => $session->url
        ]);
    }

    public function success($request): JsonResponse
    {
        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            return json(__('response.failed') ,__('response.payment.sessionId') , '' ,400);
        }

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $session = $stripe->checkout->sessions->retrieve($sessionId);
        $paymentIntent = $stripe->paymentIntents->retrieve($session->payment_intent);

        if ($paymentIntent->status !== 'succeeded') {
            return json(__('response.failed') , __('response.payment.not_completed') , '',400);
        }

        $result = $this->createPayment($paymentIntent);
        if(!$result['success']){
            return json(__('response.failed'),$result['message'], '',400);
        }
        return json(__('response.success') , __('response.payment.pay') ,'',200 );
    }

    public function cancel()
    {
        return response()->json(['message' => 'Payment canceled.']);
    }

    public function webhook($request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        }catch (\Exception $e) {
            return response('Invalid', 400);
        }
        if ($event->type === 'payment_intent.succeeded') {
            $paymentIntent = $event->data->object;
            $result = $this->createPayment($paymentIntent);
            if(!$result){
                return response('Payment not stored', 400);
            }
        }
        return response('Webhook Handled', 200);
    }

    public function createPayment($paymentIntent): array
    {
        DB::beginTransaction();
        try {
            $payment     = Payment::where('transaction_id', $paymentIntent->id)->first();
            $offer       = Offer::find( $paymentIntent->metadata->offer_id);
            $clientOffer = $offer->clientOffers()
                ->where('client_profile_id', $paymentIntent->metadata->user_id)
                ->where('is_paid' , false)
                ->first();

            if(!$payment && ($clientOffer->created_at)->addDay($offer->payment_timeout) > now()){
                $clientOffer->update(['is_paid' => true]);
                $clientOffer->save();
                Payment::create([
                    'transaction_id'  => $paymentIntent->id,
                    'offer_id'        => $offer->id,
                    'user_id'         => $paymentIntent->metadata->user_id,
                    'payment_method'  => $paymentIntent->payment_method,
                    'price'           => $offer->original_price,
                    'discount_type'   => $offer->discount_type,
                    'discount_value'  => $offer->discount_value,
                    'total'           => $offer->getDiscountedPrice($offer->original_price),
                    'status'          => 'paid',
                    'paid_at'         => now(),
                    ]);
            }
            DB::commit();
            return ['success' => true];
        }catch (\Exception $e){
            DB::rollBack();
            return [
                'success' => false,
                'message' => __('response.payment.offer_closed'),
                'code' => 403
            ];
        }
    }

}
