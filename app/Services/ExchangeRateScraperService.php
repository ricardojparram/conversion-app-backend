<?php

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ExchangeRateScraperService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function scrapeRates(): array
    {
        $url = 'https://www.bcv.org.ve/';
        $response = $this->client->get($url, [
            'verify' => false, // Deshabilita la verificación SSL
        ]);
        $html = $response->getBody()->getContents();

        $crawler = new Crawler($html);

        $euro = $crawler->filter('#euro')->first()->text();
        $dolar = $crawler->filter('#dolar')->first()->text();
        return ['euro' => explode(' ', $euro)[1], 'dolar' => explode(' ', $dolar)[1]];
    }
    public function getBinanceRates($amount = 10000): array
    {
        $url = 'https://p2p.binance.com/bapi/c2c/v2/friendly/c2c/adv/search';
        $response = $this->client->post($url, [
            'verify' => false, // Deshabilita la verificación SSL
            'headers' => [
                'Accept' => '*/*',
                'Content-Type' => 'application/json',
                'Origin' => 'https://p2p.binance.com',
                'User-Agent' => 'Mozilla/5.0',
            ],
            'json' => [
                "fiat" => "VES",
                "page" => 1,
                "rows" => 10,
                "tradeType" => "SELL",
                "asset" => "USDT",
                "countries" => [],
                "proMerchantAds" => false,
                "shieldMerchantAds" => false,
                "filterType" => "all",
                "periods" => [],
                "additionalKycVerifyFilter" => 0,
                "publisherType" => "merchant",
                "payTypes" => [],
                "classifies" => [
                    "mass",
                    "profession",
                    "fiat_trade"
                ],
                "tradedWith" => false,
                "followed" => false,
                "transAmount" => $amount

            ]
        ]);
        $json = $response->getBody()->getContents();
        $body = json_decode($json, true);

        ["data" => $rates] = $body;
        $filteredRates = array_filter($rates, function ($rate) {
            return $rate['privilegeType'] !== 8;
        });
        $sum = array_reduce($filteredRates, function ($carry, $item) {
            return $carry + (float)$item['adv']['price'];
        });

        $averageRate = count($filteredRates) > 0 ? $sum / count($filteredRates) : 0;

        return ['amount' => $amount, 'average' => (float)number_format($averageRate, 2)];
    }
}
