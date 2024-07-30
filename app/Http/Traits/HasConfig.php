<?php

namespace App\Http\Traits;

use App\Models\Doller;
use App\Models\FinanceTransaction;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\Voucher;
use AyubIRZ\PerfectMoneyAPI\PerfectMoneyAPI;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait HasConfig
{
    private function validationFiledUser()
    {
        if ($user=Auth::user()) {
            if (empty($user->name) || empty($user->family) || empty($user->national_code) || empty($user->mobile) || empty($user->tel) || empty($user->address) || empty($user->email)) {
                return true;
            } else return false;
        }

    }

}
