<?php

use App\Models\Doller;
use App\Models\File;
use App\Models\Invoice;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use AyubIRZ\PerfectMoneyAPI\PerfectMoneyAPI;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;


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
        Route::get('error/{payment}', [App\Http\Controllers\Panel\PanelController::class, 'error'])->name('panel.error');
        Route::prefix('user')->group(function () {
            Route::get('completion-of-information', [App\Http\Controllers\Panel\UserController::class, 'completionOfInformation'])->name('panel.user.completionOfInformation');
            Route::post('completion-of-information', [App\Http\Controllers\Panel\UserController::class, 'register'])->name('panel.user.register');
            Route::get('edit', [App\Http\Controllers\Panel\UserController::class, 'edit'])->name('panel.user.edit');
            Route::post('update', [App\Http\Controllers\Panel\UserController::class, 'update'])->name('panel.user.update');
        });
    });
    Route::get('contact-us', [App\Http\Controllers\Panel\PanelController::class, 'contactUs'])->name('panel.contactUs');
    Route::get('purchase', [App\Http\Controllers\Panel\PanelController::class, 'purchase'])->name('panel.purchase.view');


    Route::get('transmission', [App\Http\Controllers\Panel\TransmissionController::class, 'index'])->name('panel.transmission.view');
    Route::get('remittance-transfer-information/{transitionDelivery}', [App\Http\Controllers\Panel\TransmissionController::class, 'information'])->name('panel.transfer.information');
    Route::get('transmission-fail', [App\Http\Controllers\Panel\TransmissionController::class, 'transmissionFail'])->name('panel.transfer.fail');

    Route::middleware('LimitedPurchase')->group(function () {
        Route::post('purchase', [App\Http\Controllers\Panel\PanelController::class, 'store'])->name('panel.purchase');
        Route::post('Purchase-through-the-bank', [App\Http\Controllers\Panel\PanelController::class, 'PurchaseThroughTheBank'])->name('panel.PurchaseThroughTheBank');
        Route::post('transmission', [App\Http\Controllers\Panel\TransmissionController::class, 'store'])->name('panel.transmission');
        Route::post('voucher-transfer-through-bank', [App\Http\Controllers\Panel\TransmissionController::class, 'transferFromThePaymentGateway'])->name('panel.transferFromThePaymentGateway');
        Route::post('back/voucher-transfer-through-bank', [App\Http\Controllers\Panel\TransmissionController::class, 'transferFromThePaymentGatewayBack'])->name('panel.back.transferFromThePaymentGateway')->withoutMiddleware(Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);


    });
    Route::post('back/Purchase-through-the-bank', [App\Http\Controllers\Panel\PanelController::class, 'backPurchaseThroughTheBank'])->name('panel.Purchase-through-the-bank')->withoutMiddleware(Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
    Route::get('wallet-charging', [App\Http\Controllers\Panel\PanelController::class, 'walletCharging'])->name('panel.wallet.charging');
    Route::get('wallet-charging-Preview', [App\Http\Controllers\Panel\PanelController::class, 'walletChargingPreview'])->name('panel.wallet.charging-Preview');
    Route::post('wallet-charging', [App\Http\Controllers\Panel\PanelController::class, 'walletChargingStore'])->name('panel.wallet.charging.store');
    Route::post('back/wallet-charging', [App\Http\Controllers\Panel\PanelController::class, 'walletChargingBack'])->name('panel.wallet.charging.back')->withoutMiddleware(Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);;
    Route::get('delivery-bank/{invoice}/{payment}', [App\Http\Controllers\Panel\PanelController::class, 'deliveryVoucherBankView'])->name('panel.deliveryVoucherBankView');
    Route::post('delivery-bank/{invoice}/{payment}', [App\Http\Controllers\Panel\PanelController::class, 'deliveryVoucherBank'])->name('panel.deliveryVoucherBank');
    Route::middleware('IsEmptyUserInformation')->group(function () {
        Route::get('orders', [App\Http\Controllers\Panel\OrderController::class, 'index'])->name('panel.order');
        Route::get('order/{financeTransaction}/details', [App\Http\Controllers\Panel\OrderController::class, 'details'])->name('panel.order.details');
        Route::get('expectation', [App\Http\Controllers\Panel\OrderController::class, 'Expectation'])->name('panel.order.expectation');
        Route::get('expectation/{invoice}/details', [App\Http\Controllers\Panel\OrderController::class, 'ExpectationDetails'])->name('panel.order.expectation.details');

    });
    Route::get('delivery', [App\Http\Controllers\Panel\PanelController::class, 'delivery'])->name('panel.delivery');


    Route::get('tickets', [App\Http\Controllers\Panel\TicketController::class, 'index'])->name('panel.ticket');
    Route::get('contact-us', [App\Http\Controllers\Panel\PanelController::class, 'contactUs'])->name('panel.contactUs');

    Route::get('ticket-chat/{ticket}', [App\Http\Controllers\Panel\TicketController::class, 'ticketChat'])->name('panel.ticket-chat');
    Route::post('ticket-client-message', [App\Http\Controllers\Panel\TicketController::class, 'ticketMessage'])->name('panel.ticket-client-message');
    Route::view('ticket-add', 'Panel.Ticket.addTicket')->name('panel.ticket-add');
    Route::post('ticket-add-submit', [App\Http\Controllers\Panel\TicketController::class, 'ticketAddSubmit'])->name('panel.ticket-add-submit');
    Route::get('download/{file}', [App\Http\Controllers\Panel\TicketController::class, 'download'])->name('panel.ticket.download');
    Route::get('faq', [App\Http\Controllers\Panel\FaqController::class, 'index'])->name('panel.faq');
});

// Admin


Route::prefix('admin')->middleware(['auth', 'AdminLogin'])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('panel.admin');
    Route::get('login-another-user/{user}', [App\Http\Controllers\Admin\AdminController::class, 'loginAnotherUser'])->name('panel.admin.login-another-user');
    Route::get('tickets', [App\Http\Controllers\Admin\TicketController::class, 'index'])->name('panel.admin.tickets');
    Route::get('ticket/close/{ticket}', [App\Http\Controllers\Admin\TicketController::class, 'closeTicket'])->name('panel.admin.tickets.close');
    Route::get('ticket-page', [App\Http\Controllers\Admin\TicketController::class, 'ticketPage'])->name('panel.admin.ticket-page');
    Route::get('ticket-chat/{ticket_id}', [App\Http\Controllers\Admin\TicketController::class, 'ticketChat'])->name('panel.admin.ticket-chat');
    Route::post('ticket-message', [App\Http\Controllers\Admin\TicketController::class, 'ticketMessage'])->name('panel.admin.ticket-message');
    Route::get('dollar-price', [App\Http\Controllers\Admin\DollarController::class, 'index'])->name('panel.admin.dollar-price');
    Route::get('dollar-price-submit', [App\Http\Controllers\Admin\DollarController::class, 'priceSubmit'])->name('panel.admin.dollar-price-submit');

    Route::prefix('user')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('panel.admin.user.index');
    });
});


Route::fallback(function () {
    abort(404);
});

Route::get('test', function () {
    return view('Panel.Delivery.bankDelivery');

});

