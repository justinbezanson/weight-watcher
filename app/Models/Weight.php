<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Weight extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'type',
        'weight',
    ];

    public static function convertToLbs(float $weight): float
    {
        return round($weight * 2.20462, 2);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getWeight(): float
    {
        if ($this->user['lbs']) {
            return round($this->attributes['amount'] * 2.20462, 2);
        }

        return round($this->attributes['amount'], 2);
    }
}
