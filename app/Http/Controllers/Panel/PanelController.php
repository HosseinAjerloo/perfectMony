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
use App\Services\SmsService\SatiaService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use AyubIRZ\PerfectMoneyAPI\PerfectMoneyAPI;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use function Laravel\Prompts\alert;


class PanelController extends Controller
{
    use HasConfig;

    public function __construct()
    {
        return true;
    }

    public function index()
    {
        $user = Auth::user();
        $UserInformationStatus = $this->validationFiledUser();
        $balance = $user->getCreaditBalance();
        return view('Panel.index', compact('balance', 'UserInformationStatus'));
    }

    public function contactUs()
    {
        return view('Panel.ContactUs.ContactUs');
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
            $satiaService=new SatiaService();

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
                $inputs['description'] = 'خرید کارت هدیه پرفکت مانی';
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
                        'description' => 'خرید ووچر و کسر مبلغ از کیف پول',
                        'time_price_of_dollars' => $dollar->DollarRateWithAddedValue()

                    ]);
                    $invoice->update(['status' => 'finished']);
                    $payment_amount = $service->amount;
                    if ($this->validationFiledUser()) {
                        $request->session()->put('voucher_id', $voucher->id);
                        $request->session()->put('amount_voucher', $payment_amount);
                    }
                    $message = "سلام کارت هدیه  شما ایجاد شد اطلاعات بیشتر در قسمت سفارشات قابل دسترس می باشد.";
                    $satiaService->send($message, $user->mobile, env('SMS_Number'), env('SMS_Username'), env('SMS_Password'));
                    return redirect()->route('panel.delivery')->with(['voucher' => $voucher, 'payment_amount' => $payment_amount]);

                } else {
                    $voucher->update([
                        'status' => 'failed',
                        'description' => "به دلیل مشکل فنی روند ساخت پرفکت مانی به مشکل خورد",
                    ]);
                    $invoice->update(['status' => 'failed','description'=>'خرید کارت هدیه پرفکت مانی ناموفق بود و عملیات کسر موجودی از کیف پول متوقف شد']);

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
                $inputs['description'] = 'خرید کارت هدیه پرفکت مانی';
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
                        'description' => 'خرید ووچر و کسر مبلغ از کیف پول',
                        'time_price_of_dollars' => $dollar->DollarRateWithAddedValue()
                    ]);
                    $invoice->update(['status' => 'finished']);


                    $payment_amount = $inputs['custom_payment'];
                    if ($this->validationFiledUser()) {
                        $request->session()->put('voucher_id', $voucher->id);
                        $request->session()->put('amount_voucher', $payment_amount);
                    }
                    $message = "سلام کارت هدیه  شما ایجاد شد اطلاعات بیشتر در قسمت سفارشات قابل دسترس می باشد.";
                    $satiaService->send($message, $user->mobile, env('SMS_Number'), env('SMS_Username'), env('SMS_Password'));
                    return redirect()->route('panel.delivery')->with(['voucher' => $voucher, 'payment_amount' => $payment_amount]);


                } else {
                    $voucher->update([
                        'status' => 'failed',
                        'description' => "به دلیل مشکل فنی روند ساخت پرفکت مانی به مشکل خورد",
                    ]);
                    $invoice->update(['status' => 'failed','description'=>'خرید کارت هدیه پرفکت مانی ناموفق بود و عملیات کسر موجودی از کیف پول متوقف شد']);

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
        $balance = Auth::user()->getCreaditBalance();

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
        $inputs['bank_id'] = $bank->id;
        $inputs['time_price_of_dollars'] = $dollar->DollarRateWithAddedValue();
        $inputs['description'] = ' خرید کارت هدیه پرفکت مانی از طریق '.$bank->name;

        $invoice = Invoice::create($inputs);
        $objBank = new $bank->class;
        $objBank->setTotalPrice($voucherPrice);
        $payment = Payment::create(
            [
                'bank_id' => $bank->id,
                'invoice_id' => $invoice->id,
                'amount' => $voucherPrice,
                'state' => 'requested',

            ]
        );
        $payment->update(['order_id' => $payment->id + Payment::transactionNumber]);
        $objBank->setOrderID($payment->id + Payment::transactionNumber);
        $objBank->setBankUrl($bank->url);
        $objBank->setTerminalId($bank->terminal_id);
        $objBank->setUrlBack(route('panel.Purchase-through-the-bank'));

        $status = $objBank->payment();
        $financeTransaction = FinanceTransaction::create([
            'user_id' => $user->id,
            'amount' => $payment->amount,
            'type' => "bank",
            "creadit_balance" => $balance ,
            'description' => " ارتباط با بانک $bank->name",
            'payment_id' => $payment->id,
        ]);
        if (!$status) {
            $invoice->update(['status' => 'failed','description'=>"به دلیل عدم ارتباط با بانک $bank->name سفارش شما لغو شد "]);
            $financeTransaction->update(['description'=>"به دلیل عدم ارتباط با بانک $bank->name سفارش شما لغو شد ",'status'=>'fail']);
            return redirect()->route('panel.purchase.view')->withErrors(['error' => 'ارتباط با بانک فراهم نشد لطفا چند دقیقه بعد تلاش فرماید.']);
        }
        $url = $objBank->getBankUrl();
        $token = $status;

        session()->put('payment', $payment->id);
        session()->put('financeTransaction', $financeTransaction->id);
        Log::channel('bankLog')->emergency(PHP_EOL . 'Connection with the bank payment gateway '
            . PHP_EOL .
            'Name of the bank: ' . $bank->name
            . PHP_EOL .
            'payment price: ' . $voucherPrice
            . PHP_EOL .
            'payment date: ' . Carbon::now()->toDateTimeString()
            . PHP_EOL .
            'user ID: ' . $user->id
            . PHP_EOL
        );
        return view('welcome', compact('token', 'url'));
    }

//
    public function backPurchaseThroughTheBank(Request $request)
    {
        $satiaService=new SatiaService();

        $dollar = Doller::orderBy('id', 'desc')->first();
        $user = Auth::user();
        $balance = Auth::user()->getCreaditBalance();
        $inputs = $request->all();
        $payment = Payment::find(session()->get('payment'));
        $financeTransaction = FinanceTransaction::find(session()->get('financeTransaction'));
        $bank = $payment->bank;
        $objBank = new $bank->class;
        Log::channel('bankLog')->emergency(PHP_EOL . "Return from the bank and the bank's response to the purchase of the service " . PHP_EOL . json_encode($request->all()) . PHP_EOL .
            'Bank message: ' . PHP_EOL . $objBank->samanTransactionStatus($request->input('Status')) . PHP_EOL .
            'user ID :' . $user->id
            . PHP_EOL
        );
        $invoice = $payment->invoice;
        if (!$objBank->backBank()) {
            $payment->update(
                [
                    'RefNum' => null,
                    'ResNum' => $inputs['ResNum'],
                    'state' => 'failed'

                ]);
            $invoice->update(['status' => 'failed','description'=>' پرداخت موفقیت آمیز نبود ' . $objBank->samanTransactionStatus($request->input('Status'))]);
            $financeTransaction->update(['description'=>' پرداخت موفقیت آمیز نبود ' . $objBank->samanTransactionStatus($request->input('Status')),'status'=>'fail']);

            $bankErrorMessage="درگاه بانک سامان تراکنش شمارا به دلیل ".$objBank->samanTransactionStatus($request->input('Status'))." ناموفق اعلام کرد باتشکر سایناارز".PHP_EOL.'پشتیبانی بانک سامان'.PHP_EOL.'021-6422';
            $satiaService->send($bankErrorMessage, $user->mobile, env('SMS_Number'), env('SMS_Username'), env('SMS_Password'));

            return redirect()->route('panel.purchase.view')->withErrors(['error' => ' پرداخت موفقیت آمیز نبود ' . $objBank->samanTransactionStatus($request->input('Status'))]);
        }
        $client = new \SoapClient("https://verify.sep.ir/Payments/ReferencePayment.asmx?WSDL");

        $back_price = $client->VerifyTransaction($inputs['RefNum'], $bank->terminal_id);
        if ($back_price != $payment->amount or Payment::where("order_id", $inputs['ResNum'])->count() > 1) {
            $invoice->update(['status' => 'failed','description'=>' پرداخت موفقیت آمیز نبود ' . $objBank->samanVerifyTransaction($back_price)]);
            $financeTransaction->update(['description'=>' پرداخت موفقیت آمیز نبود ' . $objBank->samanVerifyTransaction($back_price),'status'=>'fail']);

            $bankErrorMessage="درگاه بانک سامان تراکنش شمارا به دلیل ".$objBank->samanVerifyTransaction($back_price)." ناموفق اعلام کرد باتشکر سایناارز".PHP_EOL.'پشتیبانی بانک سامان'.PHP_EOL.'021-6422';

            $satiaService->send($bankErrorMessage, $user->mobile, env('SMS_Number'), env('SMS_Username'), env('SMS_Password'));
            Log::channel('bankLog')->emergency(PHP_EOL . "Bank Credit VerifyTransaction Purchase Voucher : " . json_encode($request->all()) . PHP_EOL .
                'Bank message: ' . $objBank->samanVerifyTransaction($back_price) .
                PHP_EOL .
                'user Id: ' . $user->id
                . PHP_EOL
            );
            return redirect()->route('panel.error', $payment->id);
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
            $financeTransaction->update([
                'user_id' => $user->id,
                'amount' => $payment->amount,
                'type' => "deposit",
                "creadit_balance" => $balance + $payment->amount,
                'description' => ' افزایش کیف پول',
                'payment_id' => $payment->id,
                'time_price_of_dollars' => $dollar->DollarRateWithAddedValue()
            ]);

            FinanceTransaction::create([
                'user_id' => $user->id,
                'voucher_id' => $voucher->id,
                'amount' => $payment->amount,
                'type' => "withdrawal",
                "creadit_balance" => $financeTransaction->creadit_balance - $payment->amount,
                'description' => 'خرید ووچر و برداشت مبلغ از کیف پول',
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
            if ($this->validationFiledUser()) {
                $request->session()->put('voucher_id', $voucher->id);
                $request->session()->put('amount_voucher', $payment_amount);
            }
            $message = "سلام کارت هدیه  شما ایجاد شد اطلاعات بیشتر در قسمت سفارشات قابل دسترس می باشد.";
            $satiaService->send($message, $user->mobile, env('SMS_Number'), env('SMS_Username'), env('SMS_Password'));
            return redirect()->route('panel.delivery')->with(['voucher' => $voucher, 'payment_amount' => $payment_amount]);


        } else {
            $voucher->delete();
            $financeTransaction->update([
                'user_id' => $user->id,
                'voucher_id' => null,
                'amount' => $payment->amount,
                'type' => "deposit",
                "creadit_balance" => $balance + $payment->amount,
                'description' => 'پرداخت با موفقیت انجام شد به دلیل عدم ارتباط با پرفکت مانی مبلغ کیف پول شما افزایش داده شد و شما میتوانید در یک ساعت آینده از کیف پول خود ووچر خودرا تهیه کنید',
                'payment_id' => $payment->id,
                'time_price_of_dollars' => $dollar->DollarRateWithAddedValue()

            ]);
            $message = "پرداخت با موفقیت انجام شد به دلیل عدم ارتباط با پرفکت مانی مبلغ کیف پول شما افزایش داده شد و شما میتوانید در یک ساعت آینده از کیف پول خود ووچر خودرا تهیه کنید" ;
            $satiaService->send($message, $user->mobile, env('SMS_Number'), env('SMS_Username'), env('SMS_Password'));
            $invoice->update(['status' => 'finished','description'=>'پرداخت با موفقیت انجام شد به دلیل عدم ارتباط با پرفکت مانی مبلغ کیف پول شما افزایش داده شد و شما میتوانید در یک ساعت آینده از کیف پول خود ووچر خودرا تهیه کنید']);
            return redirect()->route('panel.purchase.view')->with(['success' => "پرداخت با موفقیت انجام شد به دلیل عدم ارتباط با پرفکت مانی مبلغ کیف پول شما افزایش داده شد."]);
        }

    }

    public function walletCharging(Request $request)
    {
        $banks = Bank::where('is_active', 1)->get();
        $user = Auth::user();
        $balance = $user->getCreaditBalance();
        $balance = numberFormat($balance);
        return view("Panel.RechargeWallet.index", compact('balance', 'banks'));
    }

    public function walletChargingPreview(WalletChargingRequest $request)
    {
        $user=Auth::user();
        $inputs = $request->all();
        $payment = Payment::create(
            [
                'state' => 'requested',
            ]);
        $balance = $user->getCreaditBalance();

        $payment->update(['order_id' => $payment->id + Payment::transactionNumber]);
        $inputs['orderID'] = $payment->id + Payment::transactionNumber;
        session()->put('payment', $payment->id);

        return view("Panel.RechargeWallet.FinalApproval", compact('inputs','balance'));
    }

    public function walletChargingStore(WalletChargingRequest $request)
    {

        if (session()->has('payment')) {
            $inputs = $request->all();
            $payment = Payment::find(session()->get('payment'));
            $inputs['price'] .= 0;
            $bank = Bank::find($inputs['bank_id']);
            $user = Auth::user();

            $inputs['final_amount'] = $inputs['price'];
            $inputs['type'] = 'wallet';
            $inputs['status'] = 'requested';
            $inputs['bank_id'] = $bank->id;
            $inputs['user_id'] = $user->id;
            $inputs['description'] = ' افزایش مبلغ کیف پول '.$bank->name;
            $invoice = Invoice::create($inputs);


            $objBank = new $bank->class;
            $objBank->setTotalPrice($inputs['price']);
            $objBank->setBankUrl($bank->url);

            $objBank->setOrderID($payment->id + Payment::transactionNumber);
            $objBank->setTerminalId($bank->terminal_id);
            $objBank->setUrlBack(route('panel.wallet.charging.back'));

            session()->put('payment', $payment->id);
            session()->put('invoice', $invoice->id);
            $payment = $payment->update(
                [
                    'bank_id' => $bank->id,
                    'amount' => $inputs['price'],
                    'invoice_id' => $invoice->id

                ]);

            $status = $objBank->payment();
            if (!$status) {
                $invoice->update(['status' => 'failed','description'=>"به دلیل عدم ارتباط با بانک $bank->name شارژ کیف پول انجام نشد "]);

                return redirect()->route('panel.index')->withErrors(['error' => 'ارتباط با بانک فراهم نشد لطفا چند دقیقه بعد تلاش فرماید.']);
            }
            $url = $objBank->getBankUrl();
            $token = $status;
            Log::channel('bankLog')->emergency(PHP_EOL . 'Connection with the bank payment gateway to charge the wallet '
                . PHP_EOL .
                'Name of the bank: ' . $bank->name
                . PHP_EOL .
                'payment price: ' . $inputs['price']
                . PHP_EOL .
                'payment date: ' . Carbon::now()->toDateTimeString()
                . PHP_EOL .
                'user ID: ' . $user->id
                . PHP_EOL

            );


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
        Log::channel('bankLog')->emergency(PHP_EOL . "Back from the bank and the bank's response to charging the wallet " . PHP_EOL . json_encode($request->all()) . PHP_EOL .
            'Bank message: ' . PHP_EOL . $objBank->samanTransactionStatus($request->input('Status')) . PHP_EOL .
            'user ID :' . $user->id
            . PHP_EOL
        );
        $invoice = Invoice::find(session()->get('invoice'));
        if (!$objBank->backBank()) {
            $payment->update(
                [
                    'RefNum' => null,
                    'ResNum' => $inputs['ResNum'],
                    'state' => 'failed'

                ]);
            $invoice->update(['status' => 'failed','description'=>' پرداخت موفقیت آمیز نبود ' . $objBank->samanTransactionStatus($request->input('Status'))]);
            return redirect()->route('panel.index')->withErrors(['error' => ' پرداخت موفقیت آمیز نبود ' . $objBank->samanTransactionStatus($request->input('Status'))]);
        }
        $client = new \SoapClient("https://verify.sep.ir/Payments/ReferencePayment.asmx?WSDL");

        $back_price = $client->VerifyTransaction($inputs['RefNum'], $bank->terminal_id);
        if ($back_price != $payment->amount or Payment::where("order_id", $inputs['ResNum'])->count() > 1) {
            $invoice->update(['status' => 'failed','description'=>' پرداخت موفقیت آمیز نبود ' . $objBank->samanVerifyTransaction($back_price)]);

            Log::channel('bankLog')->emergency(PHP_EOL . "Bank Credit VerifyTransaction wallet recharge  : " . json_encode($request->all()) . PHP_EOL .
                'Bank message: ' . $objBank->samanVerifyTransaction($back_price)
                . PHP_EOL .
                'user ID :' . $user->id
                . PHP_EOL
            );
            return redirect()->route('panel.error', $payment->id);
        }
        $payment->update(
            [
                'RefNum' => $inputs['RefNum'],
                'ResNum' => $inputs['ResNum'],
                'state' => 'finished'

            ]);
        $invoice->update(['status' => 'finished']);
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

    public function error(Request $request, Payment $payment)
    {
        $user = Auth::user();
        if ($payment->invoice->user->id == $user->id)
            return view('bank.bankErrorPage', compact('payment'));
        else
            return redirect()->route('panel.index');
    }


}
