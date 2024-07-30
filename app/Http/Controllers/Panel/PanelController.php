<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Purchase\PurchaseRequest;
use App\Http\Requests\Panel\Purchase\PurchaseThroughTheBankRequest;
use App\Http\Requests\Panel\WalletCharging\WalletChargingRequest;
use App\Http\Traits\HasConfig;
use App\Models\Bank;
use App\Models\Doller;
use App\Models\FinanceTransaction;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Voucher;
use App\Notifications\IsEmptyUserInformationNotifaction;
use App\Services\BankService\Saman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use AyubIRZ\PerfectMoneyAPI\PerfectMoneyAPI;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use function Laravel\Prompts\alert;


class PanelController extends Controller
{
    use HasConfig;

    public function index()
    {

        $user = Auth::user();
        $UserInformationStatus = $this->validationFiledUser();
        $balance = $user->getCreaditBalance();
        return view('Panel.index', compact('balance', 'UserInformationStatus'));
    }

    public function purchase()
    {

        $banks = Bank::where('is_active', 1)->get();
        $services = Service::all();
        $dollar = Doller::orderBy('id', 'desc')->first();
        return view('Panel.Purchase.index', compact('services', 'dollar', 'banks'));
    }

    public function store(PurchaseRequest $request)
    {
        try {
            $inputs = request()->all();
            $dollar = Doller::orderBy('id', 'desc')->first();
            $balance = Auth::user()->getCreaditBalance();
            $user = Auth::user();
            $inputs['user_id'] = $user->id;

            if (isset($inputs['service_id'])) {
                $service = Service::find($inputs['service_id']);

                $voucherPrice = $dollar->amount_to_rials * $service->amount;

                if ($voucherPrice > $balance) {
                    return redirect()->route('panel.purchase.view')->withErrors(['Low_inventory' => "موجودی کیف پول شما کافی نیست"]);
                }
                $inputs['final_amount'] = $voucherPrice;
                $inputs['type'] = 'service';
                $invoice = Invoice::create($inputs);

                $PM = new PerfectMoneyAPI(env('PM_ACCOUNT_ID'), env('PM_PASS'));

                $PMeVoucher = $PM->createEV(env('PAYER_ACCOUNT'), $service->amount);
                $voucher = Voucher::create(
                    [
                        'user_id' => $user->id,
                        'service_id' => $inputs['service_id'],
                        'invoice_id' => $invoice->id,
                        'status' => 'requested',
                        'description' => 'ارسال در خواست به سروریس پرفکت مانی'
                    ]
                );
                if (is_array($PMeVoucher) and isset($PMeVoucher['VOUCHER_NUM']) and isset($PMeVoucher['VOUCHER_CODE'])) {
                    $voucher->update([
                        'status' => 'finished',
                        'description' => 'ارتباط با سروریس پرفکت مانی موفقیت آمیز بود',
                        "serial" => $PMeVoucher['VOUCHER_NUM'],
                        'code' => $PMeVoucher['VOUCHER_CODE']
                    ]);
                    Log::emergency("panel Controller :" . json_encode($PMeVoucher));
                    FinanceTransaction::create([
                        'user_id' => $user->id,
                        'voucher_id' => $voucher->id,
                        'amount' => $voucherPrice,
                        'type' => "withdrawal",
                        "creadit_balance" => ($balance - $voucherPrice),
                        'description' => 'خرید ووچر و کسر مبلغ از کیف پول'
                    ]);
                    $payment_amount = $service->amount;
                    return redirect()->route('panel.delivery')->with(['voucher' => $voucher, 'payment_amount' => $payment_amount]);

                } else {
                    $voucher->update([
                        'status' => 'failed',
                        'description' => "ارتباط با سروریس پرفکت مانی موفقیت آمیز بود. متن خطا ({$PMeVoucher['ERROR']})",
                    ]);
                    Log::emergency("perfectmoney error : " . $PMeVoucher['ERROR']);
                    return redirect()->route('panel.purchase.view')->withErrors(['error' => "عملیات خرید ووچر ناموفق بود در صورت کسر موجودی از کیف پول شما با پشتیبانی تماس حاصل فرمایید."]);
                }

            } elseif (isset($inputs['custom_payment'])) {


                $voucherPrice = $dollar->amount_to_rials * $inputs['custom_payment'];

                if ($voucherPrice > $balance) {
                    return redirect()->route('panel.purchase.view')->withErrors(['Low_inventory' => "موجودی کیف پول شما کافی نیست"]);
                }
                $inputs['final_amount'] = $voucherPrice;
                $inputs['type'] = 'service';
                $inputs['service_id_custom'] = $inputs['custom_payment'];

                $invoice = Invoice::create($inputs);

                $PM = new PerfectMoneyAPI(env('PM_ACCOUNT_ID'), env('PM_PASS'));

                $PMeVoucher = $PM->createEV(env('PAYER_ACCOUNT'), $inputs['custom_payment']);
                $voucher = Voucher::create(
                    [
                        'user_id' => $user->id,
                        'invoice_id' => $invoice->id,
                        'status' => 'requested',
                        'description' => 'ارسال در خواست به سروریس پرفکت مانی',
                        "service_id_custom" => $inputs['custom_payment']
                    ]
                );
                if (is_array($PMeVoucher) and isset($PMeVoucher['VOUCHER_NUM']) and isset($PMeVoucher['VOUCHER_CODE'])) {
                    $voucher->update([
                        'status' => 'finished',
                        'description' => 'ارتباط با سروریس پرفکت مانی موفقیت آمیز بود',
                        "serial" => $PMeVoucher['VOUCHER_NUM'],
                        'code' => $PMeVoucher['VOUCHER_CODE']
                    ]);
                    Log::emergency("panel Controller :" . json_encode($PMeVoucher));
                    FinanceTransaction::create([
                        'user_id' => $user->id,
                        'voucher_id' => $voucher->id,
                        'amount' => $voucherPrice,
                        'type' => "withdrawal",
                        "creadit_balance" => ($balance - $voucherPrice),
                        'description' => 'خرید ووچر و کسر مبلغ از کیف پول'
                    ]);
                    $payment_amount = $inputs['custom_payment'];
                    return redirect()->route('panel.delivery')->with(['voucher' => $voucher, 'payment_amount' => $payment_amount]);


                } else {
                    $voucher->update([
                        'status' => 'failed',
                        'description' => "ارتباط با سروریس پرفکت مانی موفقیت آمیز بود. متن خطا ({$PMeVoucher['ERROR']})",
                    ]);
                    Log::emergency("perfectmoney error : " . $PMeVoucher['ERROR']);
                    return redirect()->route('panel.purchase.view')->withErrors(['error' => "عملیات خرید ووچر ناموفق بود در صورت کسر موجودی از کیف پول شما با پشتیبانی تماس حاصل فرمایید."]);
                }


            } else {
                return redirect()->route('panel.purchase.view')->withErrors(['SelectInvalid' => "انتخاب شما معتبر نمیباشد"]);
            }

        } catch (\Exception $exception) {
            return redirect()->route('panel.purchase.view')->withErrors(['error' => "عملیات خرید ووچر ناموفق بود در صورت کسر موجودی از کیف پول شما با پشتیبانی تماس حاصل فرمایید."]);
        }

    }

    public function delivery()
    {
        if (session()->has('voucher') && session()->get('payment_amount')) {
            $voucher = session()->get('voucher');
            $payment_amount = session()->get('payment_amount');
            return view('Panel.Delivery.index', compact('voucher', 'payment_amount'));
        } else {
            return redirect()->route('panel.index');
        }
    }

    public function PurchaseThroughTheBank(PurchaseThroughTheBankRequest $request)
    {
        $dollar = Doller::orderBy('id', 'desc')->first();
        $inputs = $request->all();
        $user = Auth::user();
        $bank = Bank::find($inputs['bank']);
        $inputs['user_id'] = $user->id;
        $inputs['description'] = " خرید مستقیم ووچر از طریق $bank->name";

        if (isset($inputs['service_id'])) {
            $service = Service::find($inputs['service_id']);
            $voucherPrice = $dollar->amount_to_rials * $service->amount;
        } elseif (isset($inputs['custom_payment'])) {
            $inputs['service_id_custom'] = $inputs['custom_payment'];
            $voucherPrice = $dollar->amount_to_rials * $inputs['custom_payment'];
        } else {
            return redirect()->route('panel.purchase.view')->withErrors(['SelectInvalid' => "انتخاب شما معتبر نمیباشد"]);
        }
        $inputs['final_amount'] = $voucherPrice;
        $inputs['type'] = 'wallet';
        $invoice = Invoice::create($inputs);
        $objBank = new $bank->class;
        $objBank->setTotalPrice($voucherPrice);
        $objBank->setBankUrl($bank->url);
        $objBank->setTerminalId($bank->terminal_id);
        $objBank->setUrlBack(route('panel.back.wallet.charging'));
       $payment= Payment::create(
            [
                'bank_id' => $bank->id,
                'invoice_id' => $invoice->id,
                'amount' => $voucherPrice,
                'state' => 'requested'
            ]
        );
        $status = $objBank->payment();
        if (!$status) {
            return redirect()->route('panel.purchase.view')->withErrors(['error' => 'ارتباط با بانک فراهم نشد لطفا چند دقیقه بعد تلاش فرماید.']);
        }
        $url = $objBank->getBankUrl();
        $token = $status;
        session()->put('payment',$payment->id);
        return view('welcome', compact('token', 'url'));
    }


    public function walletCharging(WalletChargingRequest $request)
    {


    }

    public function backWalletCharging(Request $request)
    {
        dd($request->all(),session()->all());
    }


}
