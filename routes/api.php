<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Currencies;

/**
 * @OA\Info(
 *     title="API de ejemplo",
 *     version="1.0",
 *     description="Documentación de la API de ejemplo con Swagger"
 * )
 */
Route::get('/hola', [Currencies::class, 'holaMundo']);
