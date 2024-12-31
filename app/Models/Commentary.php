<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentary extends Model
{
    use HasFactory;
    public $incrementing = false; // Disable auto-increment for ID
    protected $keyType = 'int'; 
    protected $fillable = [
        'id',             // Primary key
        'fixture_id',     // Foreign key related to fixtures
        'comment',        // The commentary text
        'minute',         // The minute the event occurred
        'extra_minute',   // Additional minute, e.g., stoppage time
        'is_goal',        // Whether this commentary indicates a goal
        'is_important',   // Whether this commentary is marked as important
        'order',          // Order of the commentary
    ];
}
