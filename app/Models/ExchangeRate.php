<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
