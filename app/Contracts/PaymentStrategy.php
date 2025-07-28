<?php
namespace App\Contracts;
use Illuminate\Http\Request;

interface PaymentStrategy{

    public function payment($request);

    public function webhook($request);

}


