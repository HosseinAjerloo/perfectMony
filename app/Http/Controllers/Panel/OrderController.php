<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Doller;
use App\Models\FinanceTransaction;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user=Auth::user();

        $financeTransactions=FinanceTransaction::where('user_id',$user->id)->orderBy('created_at','desc')->get();
        return view('Panel.Orders.index',compact('financeTransactions'));
    }
    public function details(FinanceTransaction $financeTransaction)
    {
        $dollar = Doller::orderBy('id', 'desc')->first();
        return view('Panel.Orders.details',compact('financeTransaction','dollar'));
    }
    public function Expectation()
    {
        $user=Auth::user();
        $invoices=Invoice::where('user_id',$user->id)->orderBy('created_at','desc')->get();

        return view('Panel.Orders.expectation',compact('invoices'));
    }
    public function ExpectationDetails(Invoice $invoice)
    {
        $banks = Bank::where('is_active', 1)->get();
        return view('Panel.Orders.expectationDetails',compact('invoice','banks'));
    }
}
