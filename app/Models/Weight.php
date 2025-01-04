<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'weight',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getWeight(): float
    {
        if ($this->user->lbs) {
            return round($this->attributes['weight'] * 2.20462, 2);
        }

        return round($this->attributes['weight'], 2);
    }
}
