<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function getLatestExchangeRate()
    {
        return $this->exchangeRates()->latest()->first();
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
