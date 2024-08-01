<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Doller;
use App\Models\FinanceTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user=Auth::user();

        $financeTransactions=FinanceTransaction::where('user_id',$user->id)->whereNotIn('type',['deposit'])->get();
        return view('Panel.Orders.index',compact('financeTransactions'));
    }
    public function details(FinanceTransaction $financeTransaction)
    {
        $user=Auth::user();
        $dollar = Doller::orderBy('id', 'desc')->first();

        return view('Panel.Orders.details',compact('financeTransaction','dollar'));
    }
}
