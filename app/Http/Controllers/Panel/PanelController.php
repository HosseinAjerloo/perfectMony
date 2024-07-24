<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Purchase\PurchaseRequest;
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
        return $this->generateVoucher();

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

    public function howToBuy(Request $request)
    {

        $balance = Auth::user()->getCreaditBalance();
        if (!is_numeric($request->amount) or $balance < $request->amount) {
            return false;
        }
        return true;

    }

    public function walletCharging(WalletChargingRequest $request)
    {

        $dollar = Doller::orderBy('id', 'desc')->first();
        $inputs = $request->all();
        $user = Auth::user();
        $bank = Bank::find($inputs['bank']);
        $inputs['user_id'] = $user->id;
        $inputs['description'] = " شارژ کیف پول کاربر از طریق $bank->name";

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
        Payment::create(
            [
                'bank_id' => $bank->id,
                'invoice_id' => $invoice,
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
        return view('welcome', compact('token', 'url'));

    }

    public function backWalletCharging(Request $request)
    {

    }


}
