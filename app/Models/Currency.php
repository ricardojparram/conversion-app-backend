<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * schema="Currency",
 * type="object",
 * title="Currency",
 * required={"id", "name", "code", "source"},
 * @OA\Property(property="id", type="integer", example=1),
 * @OA\Property(property="name", type="string", example="BCV Dólar"),
 * @OA\Property(property="code", type="string", example="USD"),
 * @OA\Property(property="source", type="string", example="BCV"),
 * @OA\Property(property="created_at", type="string", format="date-time"),
 * @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Currency extends Model
{
    public $table = 'currencies';

    protected $fillable = [
        'name',
        'code',
        'source',
    ];

    public function exchangeRates()
    {
        return $this->hasMany(ExchangeRate::class, 'currency_id');
    }

    public function getExchangeRate($date)
    {
        return $this->exchangeRates()->whereDate('date', $date)->first();
    }

    public function lastExchangeRate()
    {
        return $this->hasOne(ExchangeRate::class, 'currency_id')->latest('date');
    }

    public function scopeBySource($query, $source)
    {
        return $query->where('source', $source);
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    public function scopeByName($query, $name)
    {
        return $query->where('name', 'like', '%' . $name . '%');
    }

    public function scopeWithExchangeRates($query)
    {
        return $query->with('exchangeRates');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
