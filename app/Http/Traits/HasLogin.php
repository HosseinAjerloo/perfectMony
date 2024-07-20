<?php

namespace App\Http\Traits;

use App\Models\Otp;
use App\Services\SmsService\SatiaService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait HasLogin
{
    protected function generateCode(Request $request)
    {
        $satiaService=new SatiaService();
        $inputs = $request->all();
        $token = Str::random('16');
        $code = rand(11111, 99999);
        $inputs['code'] = $code;
        $inputs['token'] = $token;
        $otp = Otp::create($inputs);

        $message = 'به ساینا ارز خوش آمدین کد شما جهت ورد:' . $code;
//        $satiaService->send($message, $inputs['mobile'], '30006928', 'New137', '140101101');
        return $otp;
    }
}
