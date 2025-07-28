<?php

namespace App\Contexts;

use App\Contracts\PaymentStrategy;
use App\Services\Strategies\StripeService;
use Illuminate\Http\Request;

class Context
{
    private PaymentStrategy $strategy;

    public function __construct($method)
    {
        $this->strategy = match($method) {
            'stripe' => new StripeService(),
            default => throw new \InvalidArgumentException("Unsupported payment method: $method"),
        };
    }

    public function payment($request){
        return $this->strategy->payment($request);
    }

    public function webhook($request){
        return $this->strategy->webhook($request);
    }
}
