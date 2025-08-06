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
})->dailyAt('8:00')->timezone('America/Caracas')->onFailure(function () {
    // Handle failure, e.g., log the error or notify the admin
    Log::error('Failed to scrape exchange rates.');
});

Artisan::command('scrape:exchange-rates', function () {
    dispatch(new \App\Jobs\ScrapeExchangeRatesJob());
});
