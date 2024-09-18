<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendCodeWithSmsRequest;
use App\Http\Traits\HasLogin;
use App\Models\Otp;
use App\Models\User;
use App\Services\SmsService\SatiaService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    use HasLogin;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Auth.login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function sendCode(SendCodeWithSmsRequest $request)
    {
        $otp = $this->generateCode($request);
        return redirect()->route('login.dologin', $otp->token);
    }


    public function dologin(Request $request, Otp $otp)
    {
        $expiration = Carbon::now()->subMinutes(3)->toDateTimeString();
        $otp = $otp->where('created_at', ">", $expiration)->where('token', $otp->token)->whereNull('seen_at')->first();
        if ($otp)
            return view('Auth.verify', compact('otp'));
        return redirect()->route('login.index')->withErrors(['expiration_at' => "مدت زمان استفاده از کد گذشته است و یا قبلا استفاده شده است "]);
    }

    public function login(Request $request, Otp $otp)
    {
        $validated = $request->validate([
            'SMS_code' => 'required'
        ]);
        $inputs = $request->all();
        $expiration = Carbon::now()->subMinutes(3)->toDateTimeString();
        $otp = $otp->where('created_at', ">", $expiration)->where('token', $otp->token)->whereNull('seen_at')->first();
        if (!$otp) {
            return redirect()->route('login.index')->withErrors(['expiration_at' => "مدت زمان استفاده از کد گذشته است و یا کد وارده صحیح نمیباشد "]);
        }
        $code = $otp->where('code', $inputs['SMS_code'])->whereNull('seen_at')->where('token', $otp->token)->where('created_at', ">", $expiration)->first();
        if ($code) {
            $user = User::firstOrCreate(['mobile' => $code->mobile], [
                'mobile' => $code->mobile
            ]);
            Auth::loginUsingId($user->id);
            $code->update(['seen_at'=>date('Y/m/d H:i:s',time())]);
            return redirect()->intended();

        } else {
            return redirect()->route('login.dologin', $otp->token)->withErrors(['expiration_at' => "کد وارد شده صحیح نمیباشد "]);
        }

    }

    public function resend(Request $request, Otp $otp)
    {
        $expiration = Carbon::now()->subMinutes(3)->toDateTimeString();
        $result = $otp->where('created_at', ">", $expiration)->where('token', $otp->token)->whereNull('seen_at')->first();
        if (!$result) {
            $request->request->add(['mobile' => $otp->mobile]);
            $otp = $this->generateCode($request);
            return redirect()->route('login.dologin', $otp->token);
        } else
            return redirect()->back()->withErrors(['Code_validity' => "کد شما منقصی نشده است و داری اعتبار میباشد"]);

    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
        }
        return redirect()->intended(route('login.index'));

    }
}
