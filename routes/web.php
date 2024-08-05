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
        Route::get('delivery', [App\Http\Controllers\Panel\PanelController::class, 'delivery'])->name('panel.delivery');

    });


});


Route::get('test', function () {


});
