<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Purchase\PurchaseRequest;
use App\Models\Doller;
use App\Models\Service;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    public function index()
    {
        return view('Panel.index');
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
    }
}
