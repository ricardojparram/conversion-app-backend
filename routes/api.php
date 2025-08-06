<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Currencies;
use App\Http\Controllers\ExchangeRates;

Route::get('/currencies', [Currencies::class, 'index']);
Route::get('/currencies/last-exchange-rate', [Currencies::class, 'currenciesWithLastExchangeRate']);

Route::get('/exchange-rates', [ExchangeRates::class, 'fetchRates']);
