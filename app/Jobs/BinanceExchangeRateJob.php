<?php

namespace App\Jobs;

use App\Http\Controllers\ExchangeRates;
use App\Models\Currency;
use App\Services\ExchangeRateScraperService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class BinanceExchangeRateJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(ExchangeRateScraperService $scraperService)
    {
        $rates = $scraperService->getBinanceRates();
        $binanceRate = Currency::where('id', 3)->first();
        if ((float)$binanceRate->exchangeRates()->latest()->first()->rate !== (float)$rates['average']) {
            $binanceRate->exchangeRates()->create([
                'rate' => $rates['average'],
                'date' => now(),
            ]);
        }
    }
}
