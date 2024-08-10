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
use App\Models\Service;
use App\Models\Transmission;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransmissionController extends Controller
{
    use HasConfig;

    protected $voucherNume = null;
    protected $voucherCode = null;

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
                    return redirect()->route('panel.purchase.view')->withErrors(['Low_inventory' => "موجودی کیف پول شما کافی نیست"]);
                }

                $inputs['final_amount'] = $voucherPrice;
                $inputs['type'] = 'transmission';
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
                    $this->voucherNume=$this->PMeVoucher['VOUCHER_NUM'];
                    $this->voucherCode=$this->PMeVoucher['VOUCHER_CODE'];
                    Log::emergency("panel Controller :" . json_encode($this->PMeVoucher));
                    $finance = FinanceTransaction::create([
                        'user_id' => $user->id,
                        'voucher_id' => $voucher->id,
                        'amount' => $voucherPrice,
                        'type' => "withdrawal",
                        "creadit_balance" => ($balance - $voucherPrice),
                        'description' => 'خرید ووچر و کسر مبلغ از کیف پول',
                        'time_price_of_dollars' => $dollar->DollarRateWithAddedValue()
                    ]);
                    $invoice->update(['status' => 'finished']);
                    $transition = $this->transmission($inputs['transmission']);
                    dd($transition,$voucher);
                    if (is_array($transition)) {
                        $finance->update([
                            'description' => 'انتقال ووچر و کسر مبلغ از کیف پول',
                        ]);
                        Transmission::create(
                            [
                                'user_id' => $user->id,
                                'finance_id' => $finance->id,
                                'payee_account' => $transition['Payee_Account'],
                                'payment_batch_num' => $transition['PAYMENT_BATCH_NUM'],
                                'voucher_num' => $transition['VOUCHER_NUM'],
                                'voucher_amount' => $transition['VOUCHER_AMOUNT']
                            ]
                        );
                        return redirect()->route('panel.index')->with(['success'=>'ووچر شما با موفقیت انتقال داده شد']);

                    } else {
                        $invoice->update(['status' => 'finished', 'type' => 'service']);
                        $payment_amount = $service->amount;
                        if ($this->validationFiledUser()) {
                            $request->session()->put('voucher_id', $voucher->id);
                            $request->session()->put('amount_voucher', $payment_amount);
                        }
                        return redirect()->route('panel.delivery')->with(['voucher' => $voucher, 'payment_amount' => $payment_amount])->withErrors(['error' => 'انتقال ووچر انجام نشد ووچر جدید با همان مبلغ برای شما ایجاد شد']);
                    }

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
                $inputs['type'] = 'transmission';
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
                    $this->voucherNume=$this->PMeVoucher['VOUCHER_NUM'];
                    $this->voucherCode=$this->PMeVoucher['VOUCHER_CODE'];
                    Log::emergency("panel Controller :" . json_encode($this->PMeVoucher));
                    $finance = FinanceTransaction::create([
                        'user_id' => $user->id,
                        'voucher_id' => $voucher->id,
                        'amount' => $voucherPrice,
                        'type' => "withdrawal",
                        "creadit_balance" => ($balance - $voucherPrice),
                        'description' => 'خرید ووچر و کسر مبلغ از کیف پول',
                        'time_price_of_dollars' => $dollar->DollarRateWithAddedValue()
                    ]);
                    $invoice->update(['status' => 'finished']);

                    $transition = $this->transmission($inputs['transmission']);
                    if (is_array($transition)) {
                        $finance->update([
                            'description' => 'انتقال ووچر و کسر مبلغ از کیف پول',
                        ]);
                        Transmission::create(
                            [
                                'user_id' => $user->id,
                                'finance_id' => $finance->id,
                                'payee_account' => $transition['Payee_Account'],
                                'payment_batch_num' => $transition['PAYMENT_BATCH_NUM'],
                                'voucher_num' => $transition['VOUCHER_NUM'],
                                'voucher_amount' => $transition['VOUCHER_AMOUNT']
                            ]
                        );
                        return redirect()->route('panel.index')->with(['success'=>'ووچر شما با موفقیت انتقال داده شد']);

                    } else {
                        $payment_amount = $inputs['custom_payment'];
                        if ($this->validationFiledUser()) {
                            $request->session()->put('voucher_id', $voucher->id);
                            $request->session()->put('amount_voucher', $payment_amount);
                        }
                        return redirect()->route('panel.delivery')->with(['voucher' => $voucher, 'payment_amount' => $payment_amount])->withErrors(['error' => 'انتقال ووچر انجام نشد ووچر جدید با همان مبلغ برای شما ایجاد شد']);
                    }
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

        } catch
        (\Exception $exception) {
            return redirect()->route('panel.purchase.view')->withErrors(['error' => "عملیات خرید ووچر ناموفق بود در صورت کسر موجودی از کیف پول شما با پشتیبانی تماس حاصل فرمایید."]);
        }

    }
}
