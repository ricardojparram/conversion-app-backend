<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     *     path="/api/hola",
     *     summary="Retorna un mensaje de prueba",
     *     tags={"Currencies"},
     *     @OA\Response(
     *         response=200,
     *         description="Respuesta exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="mensaje", type="string", example="hola mundo")
     *         )
     *     )
     * )
     */
    public function holaMundo()
    {
        return response()->json(['mensaje' => 'hola mundo']);
    }
}
