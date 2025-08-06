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
}
