<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * schema="ExchangeRate",
 * type="object",
 * title="ExchangeRate",
 * required={"id", "currency_id", "rate", "date"},
 * @OA\Property(property="id", type="integer", example=1),
 * @OA\Property(property="currency_id", type="integer", example=1),
 * @OA\Property(property="rate", type="number", format="float", example=4.1234),
 * @OA\Property(property="date", type="string", format="date-time", example="2023-10-01T12:00:00Z"),
 * @OA\Property(property="created_at", type="string", format="date-time"),
 * @OA\Property(property="updated_at", type="string", format="date-time"),
 * @OA\Property(property="formatted_rate", type="string", example="4.1234")
 * )
 */
class ExchangeRate extends Model
{
    public $table = 'exchange_rates';

    protected $fillable = [
        'currency_id',
        'rate',
        'date',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('date', 'desc');
    }

    public function scopeByCurrency($query, $currencyId)
    {
        return $query->where('currency_id', $currencyId);
    }

    public function scopeByDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    public function scopeWithCurrency($query)
    {
        return $query->with('currency');
    }

    public function getFormattedRateAttribute()
    {
        return number_format($this->rate, 4, '.', '');
    }
}
