<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveFixture extends Model
{
    use HasFactory;

    // public $incrementing = false; // Disable auto-incrementing for the primary key
    // protected $keyType = 'int';

    protected $fillable = [
        'fixture_id',
        'sport_id',
        'league_id',
        'season_id',
        'name',
        'starting_at',
        'length',
        'details',
        'participants',
        'weather_report',
        'venue',
        'formations',
        'metadata',
        'lineups',
        'timeline',
        'trends',
        'comments',
        'events'
        
    ];

    protected $casts = [
        // 'id' => 'integer',
        'participants' => 'array',
        'weather_report' => 'array',
        'venue' => 'array',
        'formations' => 'array',
        'metadata' => 'array',
        'lineups' => 'array',
        'timeline' => 'array',
        'trends' => 'array',
        'comments' => 'array',
        'events' => 'array',
    ];
}