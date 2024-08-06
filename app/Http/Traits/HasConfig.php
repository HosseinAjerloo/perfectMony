<?php

namespace App\Http\Traits;

use App\Models\Doller;
use App\Models\FinanceTransaction;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\Voucher;
use AyubIRZ\PerfectMoneyAPI\PerfectMoneyAPI;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait HasConfig
{
    protected $PMeVoucher = null;
    protected $totalPerDay = 0;
    protected $totalPerMonth = 0;


    private function validationFiledUser()
    {
        if ($user = Auth::user()) {
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
            $this->PMeVoucher = $PMeVoucher;
        }
    }

    protected function purchaseConditions()
    {
        $today = Carbon::now()->toDateString();
        $todayVoucher = FinanceTransaction::PurchaseLimit($today)->get();
        $inMount = Carbon::now()->format('m');
        $toMountVoucher = FinanceTransaction::PurchaseLimit(mount: $inMount)->get();

        foreach ($todayVoucher as $voucher) {
            $this->totalPerDay += $voucher->voucher->voucherAmount();
        }
        foreach ($toMountVoucher as $voucher) {
            $this->totalPerMonth += $voucher->voucher->voucherAmount();
        }
        if ($this->totalPerDay >= env('Daily_Purchase_Limit')) {
            return __('customePr.Daily_Purchase_Limit');
        }
        if ($this->totalPerMonth >= env('Monthly_Purchase_Limit')) {
            return __('customePr.Monthly_Purchase_Limit');
        }

        return true;

    }


}
