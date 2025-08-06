<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $bcvDolar = Currency::create([
            'name' => 'BCV Dólar',
            'code' => 'USD',
            'source' => 'BCV',
        ]);
        $bcvDolar->exchangeRates()->create([
            'rate' => 128.24,
            'date' => now(),
        ]);

        $bcvEuro = Currency::create([
            'name' => 'BCV Euro',
            'code' => 'EUR',
            'source' => 'BCV',
        ]);
        $bcvEuro->exchangeRates()->create([
            'rate' => 148.20,
            'date' => now(),
        ]);

        $binanceUsdt = Currency::create([
            'name' => 'Binance P2P',
            'code' => 'USDT',
            'source' => 'Binance',
        ]);
        $binanceUsdt->exchangeRates()->create([
            'rate' => 175.20,
            'date' => now(),
        ]);
    }
}
