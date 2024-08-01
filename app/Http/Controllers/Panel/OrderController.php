<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\FinanceTransaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $financeTransactions=FinanceTransaction::all();
        return view('Panel.Orders.index',compact('financeTransactions'));
    }
}
