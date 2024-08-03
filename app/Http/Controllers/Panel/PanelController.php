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
                $voucherPrice = $dollar->DollarRateWithAddedValue() * $service->amount;

                if ($voucherPrice > $balance) {
                    return redirect()->route('panel.purchase.view')->withErrors(['Low_inventory' => "موجودی کیف پول شما کافی نیست"]);
                }

                $inputs['final_amount'] = $voucherPrice;
                $inputs['type'] = 'service';
                $inputs['status'] = 'requested';
                $inputs['time_price_of_dollars'] = $dollar->DollarRateWithAddedValue();
                $invoice = Invoice::create($inputs);

                $this->generateVoucher($service->amount);

                $voucher = Voucher::create(
                    [
                        'user_id' => $user->id,
                        'service_id' => $inputs['service_id'],
                        'invoice_id' => $invoice->id,
                        'status' => 'requested',
                        'description' => 'ارسال در خواست به سروریس پرفکت مانی'
                    ]
                );
                if (is_array($this->PMeVoucher) and isset($this->PMeVoucher['VOUCHER_NUM']) and isset($this->PMeVoucher['VOUCHER_CODE'])) {
                    $voucher->update([
                        'status' => 'finished',
                        'description' => 'ارتباط با سروریس پرفکت مانی موفقیت آمیز بود',
                        "serial" => $this->PMeVoucher['VOUCHER_NUM'],
                        'code' => $this->PMeVoucher['VOUCHER_CODE']
                    ]);
                    Log::emergency("panel Controller :" . json_encode($this->PMeVoucher));
                    FinanceTransaction::create([
                        'user_id' => $user->id,
                        'voucher_id' => $voucher->id,
                        'amount' => $voucherPrice,
                        'type' => "withdrawal",
                        "creadit_balance" => ($balance - $voucherPrice),
                        'description' => 'خرید ووچر و کسر مبلغ از کیف پول'
                    ]);
                    $invoice->update(['status' => 'finished']);
                    $payment_amount = $service->amount;
                    return redirect()->route('panel.delivery')->with(['voucher' => $voucher, 'payment_amount' => $payment_amount]);

                } else {
                    $voucher->update([
                        'status' => 'failed',
                        'description' => "به دلیل مشکل فنی روند ساخت پرفکت مانی به مشکل خورد",
                    ]);
                    $invoice->update(['status' => 'failed']);

                    Log::emergency("perfectmoney error : " . $this->PMeVoucher['ERROR']);
                    return redirect()->route('panel.purchase.view')->withErrors(['error' => "عملیات خرید ووچر ناموفق بود در صورت کسر موجودی از کیف پول شما با پشتیبانی تماس حاصل فرمایید."]);
                }

            } elseif (isset($inputs['custom_payment'])) {

                $voucherPrice = $dollar->DollarRateWithAddedValue() * $inputs['custom_payment'];

                if ($voucherPrice > $balance) {
                    return redirect()->route('panel.purchase.view')->withErrors(['Low_inventory' => "موجودی کیف پول شما کافی نیست"]);
                }
                $inputs['final_amount'] = $voucherPrice;
                $inputs['type'] = 'service';
                $inputs['service_id_custom'] = $inputs['custom_payment'];
                $inputs['status'] = 'requested';
                $inputs['time_price_of_dollars'] = $dollar->DollarRateWithAddedValue();
                $invoice = Invoice::create($inputs);

                $this->generateVoucher($inputs['custom_payment']);


                $voucher = Voucher::create(
                    [
                        'user_id' => $user->id,
                        'invoice_id' => $invoice->id,
                        'status' => 'requested',
                        'description' => 'ارسال در خواست به سروریس پرفکت مانی',
                        "service_id_custom" => $inputs['custom_payment']
                    ]
                );
                if (is_array($this->PMeVoucher) and isset($this->PMeVoucher['VOUCHER_NUM']) and isset($this->PMeVoucher['VOUCHER_CODE'])) {
                    $voucher->update([
                        'status' => 'finished',
                        'description' => 'ارتباط با سروریس پرفکت مانی موفقیت آمیز بود',
                        "serial" => $this->PMeVoucher['VOUCHER_NUM'],
                        'code' => $this->PMeVoucher['VOUCHER_CODE']
                    ]);
                    Log::emergency("panel Controller :" . json_encode($this->PMeVoucher));
                    FinanceTransaction::create([
                        'user_id' => $user->id,
                        'voucher_id' => $voucher->id,
                        'amount' => $voucherPrice,
                        'type' => "withdrawal",
                        "creadit_balance" => ($balance - $voucherPrice),
                        'description' => 'خرید ووچر و کسر مبلغ از کیف پول'
                    ]);
                    $invoice->update(['status' => 'finished']);


                    $payment_amount = $inputs['custom_payment'];
                    return redirect()->route('panel.delivery')->with(['voucher' => $voucher, 'payment_amount' => $payment_amount]);


                } else {
                    $voucher->update([
                        'status' => 'failed',
                        'description' => "به دلیل مشکل فنی روند ساخت پرفکت مانی به مشکل خورد",
                    ]);
                    $invoice->update(['status' => 'failed']);

                    Log::emergency("perfectmoney error : " . $this->PMeVoucher['ERROR']);
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
            $voucherPrice = $dollar->DollarRateWithAddedValue() * $service->amount;
        } elseif (isset($inputs['custom_payment'])) {
            $inputs['service_id_custom'] = $inputs['custom_payment'];
            $voucherPrice = $dollar->DollarRateWithAddedValue() * $inputs['custom_payment'];
        } else {
            return redirect()->route('panel.purchase.view')->withErrors(['SelectInvalid' => "انتخاب شما معتبر نمیباشد"]);
        }
        $inputs['final_amount'] = $voucherPrice;
        $inputs['type'] = 'service';
        $inputs['status'] = 'requested';
        $inputs['time_price_of_dollars'] = $dollar->DollarRateWithAddedValue();
        $invoice = Invoice::create($inputs);
        $objBank = new $bank->class;
        $objBank->setTotalPrice(10000);
        $payment = Payment::create(
            [
                'bank_id' => $bank->id,
                'invoice_id' => $invoice->id,
                'amount' => 10000,
                'state' => 'requested',

            ]
        );
        $payment->update(['order_id' => $payment->id]);
        $objBank->setOrderID($payment->id);
        $objBank->setBankUrl($bank->url);
        $objBank->setTerminalId($bank->terminal_id);
        $objBank->setUrlBack(route('panel.Purchase-through-the-bank'));

        $status = $objBank->payment();
        if (!$status) {
            return redirect()->route('panel.purchase.view')->withErrors(['error' => 'ارتباط با بانک فراهم نشد لطفا چند دقیقه بعد تلاش فرماید.']);
        }
        $url = $objBank->getBankUrl();
        $token = $status;
        session()->put('payment', $payment->id);
        return view('welcome', compact('token', 'url'));
    }


    public function backPurchaseThroughTheBank(Request $request)
    {
        $dollar = Doller::orderBy('id', 'desc')->first();
        $user = Auth::user();
        $balance = Auth::user()->getCreaditBalance();
        $inputs = $request->all();
        $payment = Payment::find(session()->get('payment'));
        $bank = $payment->bank;
        $objBank = new $bank->class;
        $invoice = $payment->invoice;
        if (!$objBank->backBank()) {
            $payment->update(
                [
                    'RefNum' => null,
                    'ResNum' => $inputs['ResNum'],
                    'state' => 'failed'

                ]);
            $invoice->update(['status' => 'failed']);

            return redirect()->route('panel.purchase.view')->withErrors(['error' => 'پرداخت موفقیت آمیز نبود']);
        }
        $client = new \SoapClient("https://verify.sep.ir/Payments/ReferencePayment.asmx?WSDL");

        $back_price = $client->VerifyTransaction($inputs['RefNum'], $bank->terminal_id);
        if ($back_price != $payment->amount and Payment::where("order_id", $inputs['ResNum'])->count() > 1) {
            return redirect()->route('panel.purchase.view')->withErrors(['error' => 'پرداخت موفقیت آمیز نبود']);
        }

        $payment->update(
            [
                'RefNum' => $inputs['RefNum'],
                'ResNum' => $inputs['ResNum'],
                'state' => 'finished'
            ]);
        $service = '';
        $amount = '';
        if (isset($invoice->service_id)) {
            $service = $invoice->service;
            $amount = $service->amount;
        } else {
            $amount = $invoice->service_id_custom;
        }

        $this->generateVoucher($amount);

        $voucher = Voucher::create(
            [
                'user_id' => $user->id,
                'invoice_id' => $invoice->id,
                'status' => 'requested',
                'description' => 'ارسال در خواست به سروریس پرفکت مانی',
            ]
        );
        if (isset($invoice->service_id)) {

            $voucher->update([
                'service_id' => $service->id
            ]);
        } else {
            $voucher->update([
                "service_id_custom" => $amount
            ]);
        }
        if (is_array($this->PMeVoucher) and isset($this->PMeVoucher['VOUCHER_NUM']) and isset($this->PMeVoucher['VOUCHER_CODE'])) {
            $voucher->update([
                'status' => 'finished',
                'description' => 'ارتباط با سروریس پرفکت مانی موفقیت آمیز بود',
                "serial" => $this->PMeVoucher['VOUCHER_NUM'],
                'code' => $this->PMeVoucher['VOUCHER_CODE']
            ]);
            Log::emergency("panel Controller :" . json_encode($this->PMeVoucher));
            FinanceTransaction::create([
                'user_id' => $user->id,
                'voucher_id' => $voucher->id,
                'amount' => $payment->amount,
                'type' => "bank",
                "creadit_balance" => $balance,
                'description' => 'خرید ووچر و پرداخت از طریق درگاه بانکی',
                'payment_id' => $payment->id,
                'time_price_of_dollars' => $dollar->DollarRateWithAddedValue()
            ]);
            $invoice->update(['status' => 'finished']);
            if (isset($invoice->service_id)) {
                $service = $invoice->service;
                $payment_amount = $service->amount;
            } else {
                $payment_amount = $invoice->service_id_custom;
            }
            return redirect()->route('panel.delivery')->with(['voucher' => $voucher, 'payment_amount' => $payment_amount]);


        } else {
            $voucher->delete();
            FinanceTransaction::create([
                'user_id' => $user->id,
                'voucher_id' => null,
                'amount' => $payment->amount,
                'type' => "deposit",
                "creadit_balance" => $balance + $payment->amount,
                'description' => 'پرداخت با موفقیت انجام شد به دلیل عدم ارتباط با پرفکت مانی مبلغ کیف پول شما افزایش داده شد و شما میتوانید در یک ساعت آینده از کیف پول خود ووچر خودرا تهیه منید',
                'payment_id' => $payment->id,
                'time_price_of_dollars' => $dollar->DollarRateWithAddedValue()

            ]);
            $invoice->update(['status' => 'finished']);
            return redirect()->route('panel.purchase.view')->with(['success' => "پرداخت با موفقیت انجام شد به دلیل عدم ارتباط با پرفکت مانی مبلغ کیف پول شما افزایش داده شد."]);
        }

    }

    public function walletCharging(Request $request)
    {
        $user = Auth::user();
        $balance = $user->getCreaditBalance();
        $balance = numberFormat($balance);
        return view("Panel.RechargeWallet.index", compact('balance'));
    }

    public function walletChargingPreview(WalletChargingRequest $request)
    {
        $inputs = $request->all();
        $payment = Payment::create(
            [
                'state' => 'requested',
            ]);
        $inputs['orderID'] = $payment->id;
        session()->put('payment', $payment->id);

        return view("Panel.RechargeWallet.FinalApproval", compact('inputs'));
    }

    public function walletChargingStore(WalletChargingRequest $request)
    {
        if (session()->has('payment')) {
            $inputs = $request->all();
            $inputs['price'] .= 0;
            $bank = Bank::find('1');
            $user = Auth::user();
            $objBank = new $bank->class;
            $objBank->setTotalPrice($inputs['price']);
            $objBank->setBankUrl($bank->url);

            $objBank->setOrderID(session()->get('orderID'));
            $objBank->setTerminalId($bank->terminal_id);
            $objBank->setUrlBack(route('panel.wallet.charging.back'));
            $bank = Bank::find('1');

            $payment = Payment::find(session()->get('payment'));
            $payment = $payment->update(
                ['bank_id' => $bank->id,
                    'amount' => $inputs['price'],
                ]);
            session()->put('payment', $payment->id);
            $status = $objBank->payment();
            if (!$status) {
                return redirect()->route('panel.index')->withErrors(['error' => 'ارتباط با بانک فراهم نشد لطفا چند دقیقه بعد تلاش فرماید.']);
            }
            $url = $objBank->getBankUrl();
            $token = $status;
            return view('welcome', compact('token', 'url'));
        } else {
            return redirect()->route('panel.index')->withErrors(['error' => 'خطایی رخ داد لفا مجدد بعدا تلاش فرمایید.']);
        }
    }

    public function walletChargingBack(Request $request)
    {
        $user = Auth::user();
        $lastBalance = $user->financeTransactions()->orderBy('id', 'desc')->first();
        $inputs = $request->all();
        $payment = Payment::find(session()->get('payment'));
        $bank = $payment->bank;
        $objBank = new $bank->class;
        if (!$objBank->backBank()) {
            $payment->update(
                [
                    'RefNum' => null,
                    'ResNum' => $inputs['ResNum'],
                    'state' => 'failed'

                ]);
            return redirect()->route('panel.index')->withErrors(['error' => 'پرداخت موفقیت آمیز نبود']);
        }
        $client = new \SoapClient("https://verify.sep.ir/Payments/ReferencePayment.asmx?WSDL");

        $back_price = $client->VerifyTransaction($inputs['RefNum'], $bank->terminal_id);
        if ($back_price != $payment->amount and Payment::where("order_id", $inputs['ResNum'])->count() > 1) {
            return redirect()->route('panel.purchase.view')->withErrors(['error' => 'پرداخت موفقیت آمیز نبود']);
        }
        $payment->update(
            [
                'RefNum' => $inputs['RefNum'],
                'ResNum' => $inputs['ResNum'],
                'state' => 'finished'

            ]);
        if ($lastBalance) {
            $amount = $payment->amount + $lastBalance->creadit_balance;
        } else {
            $amount = $payment->amount;
        }


        FinanceTransaction::create([
            'user_id' => $user->id,
            'amount' => $payment->amount,
            'type' => "deposit",
            "creadit_balance" => $amount,
            'description' => 'افزایش   مبلغ کیف پول',
            'payment_id' => $payment->id

        ]);
        return redirect()->route('panel.index')->with(['success' => 'پرداخت باموفقیت انجام شد و مبلغ کیف پول شما فزایش داده شد']);
    }


}
