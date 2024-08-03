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
    protected $PMeVoucher=null;
    private function validationFiledUser()
    {
        if ($user=Auth::user()) {
            if (empty($user->name) || empty($user->family) || empty($user->national_code) || empty($user->mobile) || empty($user->tel) || empty($user->address) || empty($user->email)) {
                return true;
            } else return false;
        }

    }
    protected function generateVoucher($amount)
    {
        $PM = new PerfectMoneyAPI(env('PM_ACCOUNT_ID'), env('PM_PASS'));
        $PMeVoucher = $PM->createEV(env('PAYER_ACCOUNT'), $amount);
        if (is_array($PMeVoucher) and isset($PMeVoucher['VOUCHER_NUM']) and isset($PMeVoucher['VOUCHER_CODE'])) {
            $this->PMeVoucher=$PMeVoucher;
        }
    }

}
