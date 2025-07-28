<?php

namespace App\Http\Controllers\Clients\Payments;

use App\Contexts\Context;
use App\Services\Strategies\StripeService;
use Illuminate\Http\Request;

class PaymentController
{

    public function __construct(protected StripeService $service){}

    public function pay(Request $request)
    {
        $context = new Context(request()->type);
        return $context->payment($request);
    }

    public function webhook(Request $request)
    {
        $context = new Context(request()->type);
        return $context->webhook($request);
    }

    public function success(Request $request)
    {
        return $this->service->success($request);
    }

    public function cancel(Request $request)
    {
        return $this->service->cancel($request);
    }

}
