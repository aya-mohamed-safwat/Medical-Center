<?php
namespace App\Services\Clients\Auth;

use App\Models\Otp;

class OtpService{
    public function create($number):Otp
    {
//        $code = rand(10000,99999);
        $code = 1111 ;
        $otp=Otp::create([
            'number'=>$number,
            'code'=>$code,
            'expired_at'=>now()->addMinutes(20)
        ]);
        return $otp;
    }

    public function validate(String $number, int $code):?Otp
    {
        return
            Otp::where('number',$number)
                ->where('code',$code)
                ->where('expired_at','>',now())
                ->first();
    }


}
