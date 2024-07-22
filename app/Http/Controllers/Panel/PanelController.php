<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Purchase\PurchaseRequest;
use App\Http\Traits\HasConfig;
use App\Models\Doller;
use App\Models\FinanceTransaction;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\Voucher;
use App\Notifications\IsEmptyUserInformationNotifaction;
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
        $services = Service::all();
        $dollar = Doller::orderBy('id', 'desc')->first();
        return view('Panel.Purchase.index', compact('services', 'dollar'));
    }

    public function store(PurchaseRequest $request)
    {
        $this->payment();
        try {
            $inputs = $request->all();
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

    public function howToBuy(Request $request)
    {

        $balance = Auth::user()->getCreaditBalance();
        if (!is_numeric($request->amount) or $balance < $request->amount) {
            return false;
        }
        return true;

    }

    public function payment()
    {
        dd('ad');
        $orderid = rand(100000, 999999);
        $bankRef = 13;
        $TotalPrice = 10000;


        $url = 'saman2.php';



        $bankinfo['Bank'] = "saman";
        $bankUrl = "https://sep.shaparak.ir/MobilePG/MobilePayment";
        switch ($bankinfo['Bank']) {
            case "saman" :

                $res = $this->samanGetToken($bankUrl, $orderid, $TotalPrice, $url);
                if ($res[0] == 0) {
                    echo "<pre>";
                    var_dump($res, $orderid, $TotalPrice, $url);
                    echo "<pre>";
                    die('تراکنش تکراری');
                } elseif ($res[0] == 1) {
                    $token = $res[1];

                    return view('welcome',compact('token','bankUrl'));

                }
                break;
            default :
                $_SESSION['display_message'] = "بانک انتخاب شده از سوی شما جهت انجام پرداخت آنلاین نامعتبر می باشد !";
                $_SESSION['display_message_type'] = "error";
                header('Location:' . $url);
                die();

        }



    }
    function samanGetToken($bankUrl, $orderID, $amount, $url)
    {


        $data = array(
            'action' => 'Token',
            'TerminalId' => 13595227,
            'ResNum' => $orderID,
            'Amount' => $amount,
            'RedirectUrl' => $url
        );
        $data = json_encode($data);

        $curl = curl_init($bankUrl);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data)));
        curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
        $result = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($result);

        if ($result->status == 1) {
            $token = $result->token;
            return array(1, $token);
        } else {
            return array(0, $result->errorDesc);
        }
    }
}
