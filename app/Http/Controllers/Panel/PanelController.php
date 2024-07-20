<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Purchase\PurchaseRequest;
use App\Models\Doller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanelController extends Controller
{
    public function index()
    {
        $user=Auth::user();

        $balance=$user->getCreaditBalance();
        return view('Panel.index',compact('balance'));
    }

    public function purchase()
    {

        $services=Service::all();
        $dollar=Doller::orderBy('id','desc')->first();
        return view('Panel.Purchase.index',compact('services','dollar'));
    }
    public function store(PurchaseRequest $request)
    {
       $inputs=$request->all();
        if (isset($inputs['service']))
        {
            dd('yes',$inputs);
        }elseif (isset($inputs['custom_payment']))
        {
            dd('no',$inputs);

        }else{
                return redirect()->route('panel.purchase.view')->with(['SelectInvalid'=>"انتخاب شما معتبر نمیباشد"]);
        }


    }
}
