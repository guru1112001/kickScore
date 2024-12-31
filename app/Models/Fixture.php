<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    use HasFactory;
    public $incrementing = false; // Disable auto-increment for ID
    protected $keyType = 'int'; 
    protected $fillable = [
        'id',              // Primary key
        'sport_id',        // Sport ID
        'league_id',       // League ID
        'season_id',       // Season ID
        'stage_id',        // Stage ID
        'group_id',        // Group ID
        'aggregate_id',    // Aggregate ID
        'state_id',        // State ID
        'round_id',        // Round ID
        'venue_id',        // Venue ID
        'name',            // Name of the fixture
        'starting_at',     // Starting date and time
        'result_info',     // Result information
        'leg',             // Leg of the fixture
        'details',         // Fixture details
        'length',          // Length of the fixture in minutes
    ];
}
