<?php

namespace App\Http\Traits;


use App\Models\Invoice;
use App\Models\Voucher;
use AyubIRZ\PerfectMoneyAPI\PerfectMoneyAPI;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait HasConfig
{
    protected $PMeVoucher = null;
    protected $redirectTo = 'panel.purchase.view';
    protected $message;

    protected $purchasePermitStatus = false;


    public function validationFiledUser()
    {
        $classOpp = get_class();
        if (isset($classOpp) and $classOpp == 'App\Models\User') {
            $user = $this;
        } else {
            $user = Auth::user();
        }
        if ($user) {
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

    protected function transmission($transmission, $amount)
    {
        $PM = new PerfectMoneyAPI(env('PM_ACCOUNT_ID'), env('PM_PASS'));
        $PMeVoucher = $PM->transferFund(env('PAYER_ACCOUNT'), $transmission, $amount);
        if (is_array($PMeVoucher) and isset($PMeVoucher['PAYMENT_BATCH_NUM']) and isset($PMeVoucher['Payee_Account'])) {
            return $PMeVoucher;
        } else {
            Log::emergency('The transfer did not take place, the reason for its failure: ' . json_encode($PMeVoucher));
            return false;
        }

    }

    protected function purchasePermit($invoice, $payment)
    {
        $user = Auth::user();
        $balance = Auth::user()->getCreaditBalance();
        $invoice = Invoice::where('id', $invoice->id)->where('user_id', $user->id)->where("status", 'finished')->first();
        $voucher = $invoice->voucher;

        if ($voucher) {
            $this->message = ['error' => "این سفارش قبلا توسط شما خریداری شده است لطفا جهت مشاهده سفارش از منوی داشبورد به قسمت سفارشات مراجعه فرمایید. "];
            $this->purchasePermitStatus = true;
            return $this;
        }

        if ($balance < $payment->amount) {
            $this->message = ['error' => "شارژ کیف پول  شما جهت خریداری کارت هدیه کافی نمیباشد لطفا کیف پول خود را شارژ فرمایید و مجددا خرید فرمایید.  "];
            $this->purchasePermitStatus = true;
            return $this;
        }
        return $this;


    }

    protected function redirectFunction()
    {
        return redirect()->route($this->redirectTo)->withErrors($this->message);
    }


}
