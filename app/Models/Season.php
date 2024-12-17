<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;
    public $incrementing = false; // Use API-provided IDs.
    protected $keyType = 'int'; // IDs are integers.

    protected $fillable = [
        'id',
        'sport_id',
        'league_id',
        'tie_breaker_rule_id',
        'name',
        'finished',
        'pending',
        'is_current',
        'standing_method',
        'starting_at',
        'ending_at',
    ];

    protected $casts = [
        'starting_at' => 'datetime',
        'ending_at' => 'datetime',
    ];
}
