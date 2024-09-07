<?php

namespace App\Console\Commands;

use App\Models\Doller;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ExchangeRateUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange-rate-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the exchange rate through the Nobitex network.';

    /**
     * Execute the console command.
     */
    public function handle()
    {


        $dollar = Doller::first();

        $usdt = Http::post('https://api.nobitex.ir/market/stats', [
            'srcCurrency' => 'USDT',
            'dstCurrency' => 'IRT'
        ]);
        if ($usdt->status() == 200) {
            if ($USDTIR = $usdt->json('stats') and is_array($usdt->json('stats'))) {
                if (isset($USDTIR['USDT-IRT'])) {
                    $USDTIR = $USDTIR['USDT-IRT'];
                    $dollar->update(['amount_to_rials' => $USDTIR['bestSell']]);
                }
            }
        }

    }
}
