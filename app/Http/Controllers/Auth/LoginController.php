<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterPasswordRequest;
use App\Http\Requests\Auth\SendCodeWithSmsRequest;
use App\Http\Requests\Auth\SimpleLoginPost;
use App\Http\Traits\HasLogin;
use App\Models\Otp;
use App\Models\User;
use App\Services\SmsService\SatiaService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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


    public function sendCode(SendCodeWithSmsRequest $request)
    {
        return $this->redirectSegmentation($request);
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

            $code->update(['seen_at' => date('Y/m/d H:i:s', time())]);
            Session::put(['otp' => true]);
            if (Session::has('loginBySms')) {
                Auth::loginUsingId($user->id);
                Session::remove('loginBySms');
                Session::remove('otp');
                Session::remove('user');
                return redirect()->intended(route('panel.index'));
            } else {
                $request->request->add(['mobile' => $user->mobile]);
                return $this->redirectSegmentation($request);
            }


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

    public function registerPassword(RegisterPasswordRequest $registerPasswordRequest)
    {
        $inputs = $registerPasswordRequest->all();
        if (Session::has('user'))
        {
            $user = User::find(Session::get('user'));
        }
        elseif ($registerPasswordRequest->has('mobile'))
        {
            $user = User::where('mobile', $inputs['mobile'])->first();
        }
        else{
            return redirect()->route('login.index')->withErrors(['ErrorLogin' => 'تداخلی به وجودآمد از صبر و شکیبایی شما سپاسگزاریم!']);
        }

        $password = password_hash($inputs['password'], PASSWORD_DEFAULT);
        $result = $user->update(['password' => $password]);
        return $result ? redirect()->route('login.simple')->with(['success' => 'کلمه عبور شما تنظیم شد لطفا برای ورود باکلمه عبور خود اقدام فرمایید']) : redirect()->route('login.index')->withErrors(['failChangePassword' => 'عملیات تنظیم کلمه عبور باشکست مواجه شد لطفا چمد دقیقه دیگه تلاش کنید.']);
    }

    public function simpleLogin(Request $request)
    {
        return view('Auth.simpleLogin');
    }

    public function simpleLoginPost(SimpleLoginPost $simpleLoginPost)
    {
        if (!Session::has('user'))
            return redirect()->route('login.index')->withErrors(['ErrorLogin' => 'تداخلی به وجودآمد از صبر و شکیبایی شما سپاسگزاریم!']);

        $user = User::find(Session::get('user'));
        $inputs = $simpleLoginPost->all();
        $validPassword = password_verify($inputs['password'], $user->password);
        if (!$validPassword)
            return redirect()->back()->withErrors(['passwordNotMatch' => 'کلمه عبور وارد شده صحیح نمیباشد']);
        Auth::loginUsingId($user->id);
        Session::remove('user');
        return redirect()->intended(route('panel.index'));
    }

    public function loginBySms(Request $request)
    {
        if (!Session::has('user'))
            return redirect()->route('login.index')->withErrors(['ErrorLogin' => 'تداخلی به وجودآمد از صبر و شکیبایی شما سپاسگزاریم!']);

        $user = User::find(Session::get('user'));
        if (Session::get('otp')) {
            Auth::loginUsingId($user->id);
            Session::remove('otp');
            Session::remove('user');
            return redirect()->intended(route('panel.index'));
        }
        Session::put('loginBySms', true);
        $request->merge(['mobile' => $user->mobile]);
        $otp = $this->generateCode($request);
        return redirect()->route('login.dologin', $otp->token);
    }

    public function setPassword()
    {
        return view('Auth.registerPassword');
    }

    public function forgotPassword(Request $request)
    {
        if (!Session::has('user'))
            return redirect()->route('login.index')->withErrors(['ErrorLogin' => 'تداخلی به وجودآمد از صبر و شکیبایی شما سپاسگزاریم!']);

        $user = User::find(Session::get('user'));
        $request->merge(['mobile' => $user->mobile]);
        $message = 'باسلام جهت تغییر کلمه عبور خود روی لینک زیر کلیک کنید' . PHP_EOL;
        $this->generateCode($request, $message);
        return redirect()->route('login.simple')->with(['success' => "لطفا از طریق لینک پیامک شده به خط شما تغییر کلمه عبور را انجام دهید"]);

    }

    public function forgotPasswordToken(Request $request, Otp $otp)
    {
        if (!empty($otp->seen))
            return redirect()->route('login.simple')->withErrors(['invalidOtp' => 'لینک وارد شده معتبر نمیباشد']);

        if (!Session::has('user'))
            Session::put(['user'=>User::where('mobile', $otp->mobile)->first()]);

        $otp->update(['seen_at' => date('Y-m-d H:i:s')]);
        return view('Auth.forgotPassword', compact('otp'));
    }
}
