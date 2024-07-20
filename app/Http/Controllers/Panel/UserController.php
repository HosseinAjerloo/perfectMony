<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\User\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function completionOfInformation()
    {
        return view('Panel.User.register');
    }
    public function register(RegisterRequest $request)
    {

        $user=Auth::user();
        $inputs=$request->all();
        $user->update($inputs);
        return redirect()->route('panel.index')->with(['success'=>"اطلاعات کاربری شما با موفقیت ویرایش شد "]);

    }
}
