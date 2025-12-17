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
        'amount',
    ];

    public static function convertToLbs(float $weight): float
    {
        return round($weight * 2.20462, 2);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getWeight($type = 'Weight'): float
    {
        $multiplier = $type === 'Weight' ? 2.20462 : 2.54;

        if ($this->user['lbs']) {
            return round($this->attributes['amount'] * $multiplier, 2);
        }

        return round($this->attributes['amount'], 2);
    }
}
