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


Route::middleware(['auth', 'IsEmptyUserInformation'])->group(function () {
    Route::withoutMiddleware('IsEmptyUserInformation')->group(function () {
        Route::get('', [App\Http\Controllers\Panel\PanelController::class, 'index'])->name('panel.index');
        Route::prefix('user')->group(function () {
            Route::get('completion-of-information', [App\Http\Controllers\Panel\UserController::class, 'completionOfInformation'])->name('panel.user.completionOfInformation');
            Route::post('completion-of-information', [App\Http\Controllers\Panel\UserController::class, 'register'])->name('panel.user.register');

        });
    });

    Route::get('purchase', [App\Http\Controllers\Panel\PanelController::class, 'purchase'])->name('panel.purchase.view');
    Route::post('purchase', [App\Http\Controllers\Panel\PanelController::class, 'store'])->name('panel.purchase');
    Route::get('delivery', [App\Http\Controllers\Panel\PanelController::class, 'delivery'])->name('panel.delivery');
    Route::post('howToBuy', [App\Http\Controllers\Panel\PanelController::class, 'howToBuy'])->name('panel.howToBuy');
    Route::post('wallet-charging', [App\Http\Controllers\Panel\PanelController::class, 'walletCharging'])->name('panel.wallet.charging');
    Route::get('back/wallet-charging', [App\Http\Controllers\Panel\PanelController::class, 'backWalletCharging'])->name('panel.back.wallet.charging');

});


Route::get('test', function () {
    return view('welcome');
//    $voucher=\App\Models\Voucher::first();
//    $payment_amount=2;
//    return view('Panel.Delivery.index', compact('voucher', 'payment_amount'));


//    try {


        $PMAccountID ='65049907';

        $PMPassPhrase ='hr_hon4774';
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
