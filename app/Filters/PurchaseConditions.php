<?php

namespace App\Filters;

use App\Models\FinanceTransaction;
use Carbon\Carbon;

class PurchaseConditions extends VoucherFilters
{
    /**
     * Create a new class instance.
     */


    public function DailyPurchase(): string
    {
       return __('customePr.Daily_Purchase_Limit');
    }
    public function MonthlyPurchase(): string
    {
       return __('customePr.Monthly_Purchase_Limit');
    }
}
