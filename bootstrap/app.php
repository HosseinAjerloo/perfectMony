<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn() => route('login.index'));
        $middleware->web(App\Http\Middleware\RoutingRefererConfig::class);
        $middleware->alias([
            'IsEmptyUserInformation' => \App\Http\Middleware\IsEmptyUserInformation::class,
            'LimitedPurchase' => \App\Http\Middleware\LimitedPurchaseMiddleware::class,
            'AdminLogin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        if ($exceptions instanceof HttpResponseException && $exceptions->getResponse()->getStatusCode() == Response::HTTP_GATEWAY_TIMEOUT) {
            dd('hi');
            return redirect()->route('custom_error_page');
        }
    })->create();
