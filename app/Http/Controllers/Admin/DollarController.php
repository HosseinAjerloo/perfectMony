<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DollarController extends Controller
{
    public function index(Request $request)
    {
        $dollar = Doller::all()->first();
        $dollar_price = $dollar->amount_to_rials;
        return view('Admin.Dollar.index',compact('dollar_price'));
    }

    public function priceSubmit(Request $request)
    {
        if(!$request->dollar_price)
            return redirect()->back()->withErrors(['error' => 'قیمت دلار را وارد نمایید']);

        $dollar = Doller::all()->first();
        $dollar->amount_to_rials = $request->dollar_price;
        $dollar->save();
        return redirect()->back()->with(['success' => "قیمت دلار ثبت شد"]);
    }
}
