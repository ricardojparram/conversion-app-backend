<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use Illuminate\Http\Request;

class ExchangeRates extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/exchange-rates",
     *     summary="Retorna todas las tasas de cambio",
     *     tags={"Exchange Rates"},
     *     @OA\Response(
     *         response=200,
     *         description="Respuesta exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ExchangeRate"))
     *         )
     *     )
     * )
     */
    public function fetchRates()
    {
        $rates = ExchangeRate::all();
        return response()->json(['data' => $rates]);
    }

    /**
     * @OA\Get(
     *     path="/api/exchange-rates/binance",
     *     summary="Obtiene las tasas de cambio de Binance",
     *     tags={"Exchange Rates"},
     *     @OA\Parameter(
     *         name="amount",
     *         in="query",
     *         description="Cantidad para la conversión",
     *         required=false,
     *         @OA\Schema(type="integer", default=10000)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Respuesta exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(type="string"))
     *         )
     *     )
     * )
     */
    public function fetchBinanceRates(Request $request)
    {
        $amount = $request->query('amount', 10000);
        $service = new \App\Services\ExchangeRateScraperService();
        $rates = $service->getBinanceRates($amount);


        return response()->json($rates);
    }
}
