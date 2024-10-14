<?php

namespace App\Http\Traits;

use App\Models\Otp;
use App\Models\User;
use App\Services\SmsService\SatiaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

trait HasLogin
{
    protected function generateCode(Request $request,$message=null)
    {
        $satiaService = new SatiaService();
        $inputs = $request->all();
        $token = Str::random('16');
        $code = rand(11111, 99999);
        $inputs['code'] = $code;
        $inputs['token'] = $token;
        $otp = Otp::create($inputs);
        if (!isset($message))
            $message = 'به ساینا ارز خوش آمدین کد شما جهت ورود:' . $code;
        else
            $message.=route('forgotPassword.token',$otp);
        $satiaService->send( $message, $inputs['mobile']);
        return $otp;
    }

    protected function redirectSegmentation(Request $request)
    {

        $hasUser = $this->hasUser($request);
        if ($hasUser->user) {
            $isSettPassword = $hasUser->isSetPassword();
            Session::put(['user' => $hasUser->user]);
            if (!$isSettPassword) {
                return redirect()->route('login.setPassword');
            } else {
                return redirect()->route('login.simple');
            }
        } else {
            $otp = $this->generateCode($request);
            return redirect()->route('login.dologin', $otp->token);
        }

    }

    protected function hasUser(Request $request)
    {
        $user = User::where('mobile', $request->mobile)?->first();
        $this->user = $user;
        return $this;
    }

    protected function isSetPassword(): bool
    {
        $user = $this->user;
        return $user->password ? true : false;
    }



}
