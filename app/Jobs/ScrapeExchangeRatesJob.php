<?php

namespace App\Jobs;

use App\Models\Currency;
use App\Services\ExchangeRateScraperService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScrapeExchangeRatesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle(ExchangeRateScraperService $scraperService)
    {
        $rates = $scraperService->scrapeRates();
        $rates = array_map(function ($rate) {
            return round(floatval(str_replace(',', '.', $rate)), 2);
        }, $rates);

        $currencyDolar = Currency::where('id', 1)->first();
        $actualRate = (float)$currencyDolar->exchangeRates()->latest()->first()->rate;
        if ($actualRate !== $rates['dolar']) {
            $currencyDolar->exchangeRates()->create([
                'rate' => $rates['dolar'],
                'date' => now(),
            ]);
        }
        $currencyEuro = Currency::where('id', 2)->first();
        $actualRateEuro = (float)$currencyEuro->exchangeRates()->latest()->first()->rate;
        if ($actualRateEuro !== $rates['euro']) {
            $currencyEuro->exchangeRates()->create([
                'rate' => $rates['euro'],
                'date' => now(),
            ]);
        }
    }
}
