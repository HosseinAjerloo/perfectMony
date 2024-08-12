<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Purchase\PurchaseRequest;
use App\Http\Requests\Panel\Transmission\TransmissionRequest;
use App\Http\Traits\HasConfig;
use App\Models\Bank;
use App\Models\Doller;
use App\Models\FinanceTransaction;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Transmission;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransmissionController extends Controller
{
    use HasConfig;


    public function index()
    {
        $banks = Bank::where('is_active', 1)->get();
        $services = Service::all();
        $dollar = Doller::orderBy('id', 'desc')->first();
        return view('Panel.Transmission.index', compact('services', 'dollar', 'banks'));
    }

    public function store(TransmissionRequest $request)
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
                    return redirect()->route('panel.transmission.view')->withErrors(['Low_inventory' => "موجودی کیف پول شما کافی نیست"]);
                }

                $inputs['final_amount'] = $voucherPrice;
                $inputs['type'] = 'transmission';
                $inputs['status'] = 'requested';
                $inputs['time_price_of_dollars'] = $dollar->DollarRateWithAddedValue();
                $invoice = Invoice::create($inputs);

                $transition = $this->transmission($inputs['transmission'], $service->amount);
                if (is_array($transition)) {
                    $finance = FinanceTransaction::create([
                        'user_id' => $user->id,
                        'amount' => $voucherPrice,
                        'type' => "withdrawal",
                        "creadit_balance" => ($balance - $voucherPrice),
                        'description' => 'انتقال ووچر و کسر مبلغ از کیف پول',
                        'time_price_of_dollars' => $dollar->DollarRateWithAddedValue()
                    ]);
                    $invoice->update(['status' => 'finished']);
                    Transmission::create(
                        [
                            'user_id' => $user->id,
                            'finance_id' => $finance->id,
                            'payee_account_name' => $transition['Payee_Account_Name'],
                            'payee_account' => $transition['Payee_Account'],
                            'payer_account' => $transition['Payer_Account'],
                            'payment_amount' => $transition['PAYMENT_AMOUNT'],
                            'payment_batch_num' => $transition['PAYMENT_BATCH_NUM']
                        ]
                    );
                    return redirect()->route('panel.index')->with(['success' => 'ووچر شما با موفقیت انتقال داده شد']);

                } else {
                    $invoice->update(['status' => 'failed']);
                    return redirect()->route('panel.transmission.view')->withErrors(['error' => "عملیات انتقال ووچر ناموفق بود در صورت کسر موجودی از کیف پول شما با پشتیبانی تماس حاصل فرمایید."]);
                }


            } elseif (isset($inputs['custom_payment'])) {

                $voucherPrice = $dollar->DollarRateWithAddedValue() * $inputs['custom_payment'];

                if ($voucherPrice > $balance) {
                    return redirect()->route('panel.transmission.view')->withErrors(['Low_inventory' => "موجودی کیف پول شما کافی نیست"]);
                }
                $inputs['final_amount'] = $voucherPrice;
                $inputs['type'] = 'transmission';
                $inputs['service_id_custom'] = $inputs['custom_payment'];
                $inputs['status'] = 'requested';
                $inputs['time_price_of_dollars'] = $dollar->DollarRateWithAddedValue();
                $invoice = Invoice::create($inputs);

                $transition = $this->transmission($inputs['transmission'], $inputs['custom_payment']);
                if (is_array($transition)) {
                    $finance = FinanceTransaction::create([
                        'user_id' => $user->id,
                        'amount' => $voucherPrice,
                        'type' => "withdrawal",
                        "creadit_balance" => ($balance - $voucherPrice),
                        'description' => 'انتقال ووچر و کسر مبلغ از کیف پول',
                        'time_price_of_dollars' => $dollar->DollarRateWithAddedValue()
                    ]);
                    $invoice->update(['status' => 'finished']);

                    Transmission::create(
                        [
                            'user_id' => $user->id,
                            'finance_id' => $finance->id,
                            'payee_account_name' => $transition['Payee_Account_Name'],
                            'payee_account' => $transition['Payee_Account'],
                            'payer_account' => $transition['Payer_Account'],
                            'payment_amount' => $transition['PAYMENT_AMOUNT'],
                            'payment_batch_num' => $transition['PAYMENT_BATCH_NUM']
                        ]
                    );
                    return redirect()->route('panel.index')->with(['success' => 'ووچر شما با موفقیت انتقال داده شد']);

                } else {
                    $invoice->update(['status' => 'failed']);
                    return redirect()->route('panel.transmission.view')->withErrors(['error' => "عملیات انتقال ووچر ناموفق بود در صورت کسر موجودی از کیف پول شما با پشتیبانی تماس حاصل فرمایید."]);
                }
            } else {
                return redirect()->route('panel.transmission.view')->withErrors(['SelectInvalid' => "انتخاب شما معتبر نمیباشد"]);
            }
        } catch
        (\Exception $exception) {
            return redirect()->route('panel.transmission.view')->withErrors(['error' => "عملیات انتقال ووچر ناموفق بود در صورت کسر موجودی از کیف پول شما با پشتیبانی تماس حاصل فرمایید."]);
        }

    }

    public function transferFromThePaymentGateway(TransmissionRequest $request)
    {
        $dollar = Doller::orderBy('id', 'desc')->first();
        $inputs = $request->all();
        $user = Auth::user();
        $bank = Bank::find($inputs['bank']);
        $inputs['user_id'] = $user->id;
        $inputs['description'] = " انتقال ووچر از طریق $bank->name";

        if (isset($inputs['service_id'])) {
            $service = Service::find($inputs['service_id']);
            $voucherPrice = $dollar->DollarRateWithAddedValue() * $service->amount;
        } elseif (isset($inputs['custom_payment'])) {
            $inputs['service_id_custom'] = $inputs['custom_payment'];
            $voucherPrice = $dollar->DollarRateWithAddedValue() * $inputs['custom_payment'];
        } else {
            return redirect()->route('panel.transmission.view')->withErrors(['SelectInvalid' => "انتخاب شما معتبر نمیباشد"]);
        }

        $inputs['final_amount'] = $voucherPrice;
        $inputs['type'] = 'transmission';
        $inputs['status'] = 'requested';
        $inputs['bank_id'] = $bank->id;
        $inputs['time_price_of_dollars'] = $dollar->DollarRateWithAddedValue();

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
        $payment->update(['order_id' => $payment->id+Payment::transactionNumber]);
        $objBank->setOrderID($payment->id+Payment::transactionNumber);
        $objBank->setBankUrl($bank->url);
        $objBank->setTerminalId($bank->terminal_id);
        $objBank->setUrlBack(route('panel.back.transferFromThePaymentGateway'));

        $status = $objBank->payment();
        if (!$status) {
            return redirect()->route('panel.transmission.view')->withErrors(['error' => 'ارتباط با بانک فراهم نشد لطفا چند دقیقه بعد تلاش فرماید.']);
        }
        $url = $objBank->getBankUrl();
        $token = $status;
        session()->put('transmission', $inputs['transmission']);
        session()->put('payment', $payment->id);
        return view('welcome', compact('token', 'url'));
    }

    public function transferFromThePaymentGatewayBack(Request $request)
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

            return redirect()->route('panel.transmission.view')->withErrors(['error' => 'پرداخت موفقیت آمیز نبود']);
        }
        $client = new \SoapClient("https://verify.sep.ir/Payments/ReferencePayment.asmx?WSDL");

        $back_price = $client->VerifyTransaction($inputs['RefNum'], $bank->terminal_id);
        if ($back_price != $payment->amount or Payment::where("order_id", $inputs['ResNum'])->count() > 1) {
            $invoice->update(['status' => 'failed']);
            return redirect()->route('panel.error', $payment->id);
        }

        $payment->update(
            [
                'RefNum' => $inputs['RefNum'],
                'ResNum' => $inputs['ResNum'],
                'state' => 'finished'
            ]);

        if (isset($invoice->service_id)) {
            $service = $invoice->service;
            $amount = $service->amount;
        } else {
            $amount = $invoice->service_id_custom;
        }


        $transition = $this->transmission(session()->get('transmission'), $amount);
        $invoice->update(['status' => 'finished']);
        if (is_array($transition)) {

            $financeTransaction = FinanceTransaction::create([
                'user_id' => $user->id,
                'amount' => $payment->amount,
                'type' => "deposit",
                "creadit_balance" => $balance + $payment->amount,
                'description' => ' افزایش کیف پول',
                'payment_id' => $payment->id,
                'time_price_of_dollars' => $dollar->DollarRateWithAddedValue()
            ]);

            $finance = FinanceTransaction::create([
                'user_id' => $user->id,
                'amount' => $payment->amount,
                'type' => "withdrawal",
                "creadit_balance" => $financeTransaction->creadit_balance - $payment->amount,
                'description' => 'انتقال ووچر و برداشت مبلغ از کیف پول',
                'payment_id' => $payment->id,
                'time_price_of_dollars' => $dollar->DollarRateWithAddedValue()
            ]);

            Transmission::create(
                [
                    'user_id' => $user->id,
                    'finance_id' => $finance->id,
                    'payee_account_name' => $transition['Payee_Account_Name'],
                    'payee_account' => $transition['Payee_Account'],
                    'payer_account' => $transition['Payer_Account'],
                    'payment_amount' => $transition['PAYMENT_AMOUNT'],
                    'payment_batch_num' => $transition['PAYMENT_BATCH_NUM']
                ]
            );

            return redirect()->route('panel.index')->with(['success' => 'ووچر شما با موفقیت انتقال داده شد']);


        } else {

            FinanceTransaction::create([
                'user_id' => $user->id,
                'voucher_id' => null,
                'amount' => $payment->amount,
                'type' => "deposit",
                "creadit_balance" => $balance + $payment->amount,
                'description' => 'پرداخت با موفقیت انجام شد به دلیل عدم ارتباط با پرفکت مانی مبلغ کیف پول شما افزایش داده شد و شما میتوانید در یک ساعت آینده از کیف پول خود جهت انتقال ووچر اقدام نمایید',
                'payment_id' => $payment->id,
                'time_price_of_dollars' => $dollar->DollarRateWithAddedValue()

            ]);
            return redirect()->route('panel.transmission.view')->with(['success' => "پرداخت با موفقیت انجام شد به دلیل عدم ارتباط با پرفکت مانی مبلغ کیف پول شما افزایش داده شد."]);
        }
    }
}
