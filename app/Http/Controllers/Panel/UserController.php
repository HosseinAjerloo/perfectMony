<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\User\RegisterRequest;
use App\Http\Requests\Panel\User\UpdateUserRequest;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function completionOfInformation()
    {
        $user=Auth::user();
        return view('Panel.User.register',compact('user'));
    }
    public function register(RegisterRequest $request)
    {
        $user=Auth::user();
        $inputs=$request->all();
        $user->update($inputs);
        if (session()->has('voucher_id') and  session()->has('amount_voucher'))
        {
            $voucher=Voucher::find(session()->get('voucher_id'));
            $payment_amount=session()->get('amount_voucher');
            return redirect()->route('panel.delivery')->with(['voucher' => $voucher, 'payment_amount' => $payment_amount,'success'=>"اطلاعات کاربری شما با موفقیت ویرایش شد "]);
        }
        else
        return redirect()->route('panel.index')->with(['success'=>"اطلاعات کاربری شما با موفقیت ویرایش شد "]);

    }
    public function edit()
    {
        $user=Auth::user();
        return view('Panel.User.edit',compact('user'));
    }
    public function update(UpdateUserRequest $request)
    {
        $user=Auth::user();
        $inputs=$request->all();
        $user=$user->update($inputs);
        return $user?redirect()->route('panel.index')->with(['success'=>"اطلاعات کاربری شما با موفقیت ویرایش شد "]):redirect()->route('panel.index')->withErrors(['updateError'=>"اطلاعات کاربری شما با موفقیت ویرایش شد "]);
    }
}
