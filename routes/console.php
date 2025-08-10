<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    Artisan::call('scrape:exchange-rates');
})->dailyAt('8:00')->onFailure(function () {
    Log::error('Failed to scrape exchange rates.');
});
Schedule::call(function () {
    Artisan::call('binance:exchange-rates');
})->everyMinute()->onFailure(function () {
    Log::error('Failed to scrape Binance exchange rates.');
});

Artisan::command('scrape:exchange-rates', function () {
    dispatch(new \App\Jobs\ScrapeExchangeRatesJob());
});
Artisan::command('binance:exchange-rates', function () {
    dispatch(new \App\Jobs\BinanceExchangeRateJob());
})->purpose('Dispatch Binance exchange rates job');
