<?php

use Illuminate\Support\Facades\Route;
use AyubIRZ\PerfectMoneyAPI\PerfectMoneyAPI;


Route::middleware('guest')->name('login.')->prefix('login')->group(function () {
    Route::get('', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('index');
    Route::post('', [App\Http\Controllers\Auth\LoginController::class, 'sendCode'])->name('sendCode');
    Route::get('dologin/{otp:token}', [App\Http\Controllers\Auth\LoginController::class, 'dologin'])->name('dologin');
    Route::post('dologin/{otp:token}', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('dologin.post');
    Route::post('resend/{otp:token}', [App\Http\Controllers\Auth\LoginController::class, 'resend'])->name('resend');
});
Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::withoutMiddleware('IsEmptyUserInformation')->group(function () {
        Route::get('', [App\Http\Controllers\Panel\PanelController::class, 'index'])->name('panel.index');
        Route::prefix('user')->group(function () {
            Route::get('completion-of-information', [App\Http\Controllers\Panel\UserController::class, 'completionOfInformation'])->name('panel.user.completionOfInformation');
            Route::post('completion-of-information', [App\Http\Controllers\Panel\UserController::class, 'register'])->name('panel.user.register');

        });
    });
    Route::get('contact-us', [App\Http\Controllers\Panel\PanelController::class, 'contactUs'])->name('panel.contactUs');
    Route::get('purchase', [App\Http\Controllers\Panel\PanelController::class, 'purchase'])->name('panel.purchase.view');
    Route::post('purchase', [App\Http\Controllers\Panel\PanelController::class, 'store'])->name('panel.purchase');
    Route::get('delivery', [App\Http\Controllers\Panel\PanelController::class, 'delivery'])->name('panel.delivery');
    Route::post('Purchase-through-the-bank', [App\Http\Controllers\Panel\PanelController::class, 'PurchaseThroughTheBank'])->name('panel.PurchaseThroughTheBank');
    Route::post('back/Purchase-through-the-bank', [App\Http\Controllers\Panel\PanelController::class, 'backPurchaseThroughTheBank'])->name('panel.Purchase-through-the-bank')->withoutMiddleware(Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
    Route::get('wallet-charging', [App\Http\Controllers\Panel\PanelController::class, 'walletCharging'])->name('panel.wallet.charging');
    Route::get('wallet-charging-Preview', [App\Http\Controllers\Panel\PanelController::class, 'walletChargingPreview'])->name('panel.wallet.charging-Preview');
    Route::post('wallet-charging', [App\Http\Controllers\Panel\PanelController::class, 'walletChargingStore'])->name('panel.wallet.charging.store');
    Route::post('back/wallet-charging', [App\Http\Controllers\Panel\PanelController::class, 'walletChargingBack'])->name('panel.wallet.charging.back')->withoutMiddleware(Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);;
    Route::middleware('IsEmptyUserInformation')->group(function (){
        Route::get('orders',[App\Http\Controllers\Panel\OrderController::class,'index'])->name('panel.order');
        Route::get('order/{financeTransaction}/details',[App\Http\Controllers\Panel\OrderController::class,'details'])->name('panel.order.details');
        Route::get('expectation',[App\Http\Controllers\Panel\OrderController::class,'Expectation'])->name('panel.order.expectation');
        Route::get('expectation/{invoice}/details',[App\Http\Controllers\Panel\OrderController::class,'ExpectationDetails'])->name('panel.order.expectation.details');
    });


});


Route::get('test', function () {
return view('Panel.Delivery.index');
//    if ($back_price < 0) {
//        self::update_saman_payref($orderid, $refnum);
//        self::update_order_status($orderid, 602);
//        return array(0, 602);
//    } else {
//        $order_result = mysql_query("select * from on_epayment where Serial = '$orderid' ");
//        $order_det = parent::fetchArray($order_result);
//
//        if (intval($back_price) != intval($order_det['TotalPrice'])) {
//            self::update_saman_payref($orderid, $refnum);
//            self::update_order_status($orderid, 603);
//            return array(0, 603);
//        } else {
//            self::update_saman_payref($orderid, $refnum);
//            self::update_order_payment_success($orderid);
//            return array(1, 0);
//        }

    $user=\Illuminate\Support\Facades\Auth::user();
//    return view('Panel.RechargeWallet.BackFromTheBank');
//    $voucher=\App\Models\Voucher::first();
//    $payment_amount=2;
//    return view('Panel.Delivery.index', compact('voucher', 'payment_amount'));


//    try {


    $PMAccountID = '65049907';

    $PMPassPhrase = 'hr_hon4774';
    $PM = new PerfectMoneyAPI($PMAccountID, $PMPassPhrase);


    $payerAccount = 'U47768533';

    $amount = 100;

    $PMeVoucher = $PM->getBalance();
    dd($PMeVoucher);
//
//        "Payer_Account" => "U47768533"
//  "PAYMENT_AMOUNT" => "1.01"
//  "PAYMENT_BATCH_NUM" => "608002561"
//  "VOUCHER_NUM" => "2711535715"
//  "VOUCHER_CODE" => "2386574385419054"
//  "VOUCHER_AMOUNT" => "1"
    return json_encode($PMbalance);

//    } catch (Exception $exception) {
//        return redirect()->route('panel.purchase.view')->withErrors(['ErrorCreatingVoucher' => 'ایجاد ووچر شما با خطا مواجه شد لطفا چند دقیقه دیگر تلاش کنید']);
//    }

});
