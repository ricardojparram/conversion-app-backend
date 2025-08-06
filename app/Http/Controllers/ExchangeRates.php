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
}
