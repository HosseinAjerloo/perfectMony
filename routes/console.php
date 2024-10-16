<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use \App\Jobs\VoucherBankArrangementJob;
use \App\Jobs\transmissionsBankArrangementJob;
\Illuminate\Support\Facades\Schedule::command('exchange-rate-update')->hourly()->runInBackground();
\Illuminate\Support\Facades\Schedule::job(new VoucherBankArrangementJob)->everyFiveMinutes();
//\Illuminate\Support\Facades\Schedule::job(new transmissionsBankArrangementJob)->everyFiveMinutes();
\Illuminate\Support\Facades\Schedule::command('queue:work --stop-when-empty');
\Illuminate\Support\Facades\Schedule::command('queue:work --stop-when-empty --queue perfectmoney')->everyFiveMinutes();

