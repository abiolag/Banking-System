<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'routing_number',
        'swift_code',
        'country_code',
        'currency',
        'is_active'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeUS($query)
    {
        return $query->where('country_code', 'US');
    }

    public function scopeUK($query)
    {
        return $query->where('country_code', 'GB');
    }

    public function scopeInternational($query)
    {
        return $query->whereNotIn('country_code', ['US', 'GB']);
    }

    public function getCurrencySymbolAttribute()
    {
        return match($this->currency) {
            'USD' => '$',
            'GBP' => '£',
            'EUR' => '€',
            default => '$'
        };
    }
}