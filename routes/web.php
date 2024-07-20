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
Route::get('logout',[App\Http\Controllers\Auth\LoginController::class,'logout'])->name('logout');


Route::middleware(['auth', 'IsEmptyUserInformation'])->group(function () {
    Route::withoutMiddleware('IsEmptyUserInformation')->group(function () {
        Route::get('', [App\Http\Controllers\Panel\PanelController::class, 'index'])->name('panel.index');
    });
    Route::prefix('user')->group(function (){
        Route::get('completion-of-information',[App\Http\Controllers\Panel\UserController::class,'completionOfInformation'])->name('panel.user.completionOfInformation')->withoutMiddleware('IsEmptyUserInformation');
        Route::post('completion-of-information',[App\Http\Controllers\Panel\UserController::class,'register'])->name('panel.user.register')->withoutMiddleware('IsEmptyUserInformation');

    });
    Route::get('purchase',[App\Http\Controllers\Panel\PanelController::class,'purchase'])->name('panel.purchase');
    Route::post('purchase',[App\Http\Controllers\Panel\PanelController::class,'store'])->name('panel.purchase');

});


Route::get('test',function (){

    $PMAccountID = '65049907';      // This should be replaced with your real PerfectMoney Member ID(username that you login with).

    $PMPassPhrase = 'hr_hon4774'; // This should be replaced with your real PerfectMoney PassPhrase(password that you login with).

    $PM = new PerfectMoneyAPI($PMAccountID, $PMPassPhrase);


    $payerAccount = 'U47768533'; // Replace this with one of your own wallet IDs that you want to create the E-Voucher from it.

    $amount = 1; // Replace this with the amount of currency unit(in this case 250 USD) that you want to fund the created E-Voucher. E-Voucher amount unit must be greater than 1.

    $PMeVoucher = $PM->createEV($payerAccount, $amount); // An array of E-Voucher data(Payer_Account, PAYMENT_AMOUNT, PAYMENT_BATCH_NUM, VOUCHER_NUM, VOUCHER_CODE, VOUCHER_AMOUNT) will return for a valid and successful transaction. If any error happen, an array with one item with the key "ERROR" will return.
    dd($PMeVoucher);

    $PMbalance = $PM->getBalance(); // array of all your currency wallets(as keys) and all of their balances(as values) will return.

    return json_encode($PMbalance);
    return json_encode($PMeVoucher);

});
