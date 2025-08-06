<?php


namespace App\Http\Controllers;

use App\Models\Currency;

/**
 * @OA\Info(
 *     title="Cambio rápido app API",
 *     version="1.0",
 *     description="Documentación de la API de Cambio rápido"
 * )
 */
class Currencies extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/currencies",
     *     summary="Retorna todas las monedas",
     *     tags={"Currencies"},
     *     @OA\Response(
     *         response=200,
     *         description="Respuesta exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Currency"))
     *         )
     *     )
     * )
     */
    public function index()
    {

        return response()->json(['data' => Currency::all()]);
    }

    /**
     * @OA\Get(
     *     path="/api/currencies/last-exchange-rate",
     *     summary="Retorna todas las monedas con su última tasa de cambio",
     *     tags={"Currencies"},
     *     @OA\Response(
     *         response=200,
     *         description="Respuesta exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Currency"))
     *         )
     *     )
     * )
     */
    public function currenciesWithLastExchangeRate()
    {
        $currencies = Currency::select(['id', 'name', 'code', 'source'])->with('lastExchangeRate:currency_id,rate,date')->get();

        return response()->json(['data' => $currencies]);
    }
}
