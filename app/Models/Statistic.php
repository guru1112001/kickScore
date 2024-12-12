<?php

namespace App\Models;

use App\Models\Player;
use App\Models\StatDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Statistic extends Model
{
    use HasFactory;
    public $incrementing = false; // Disable auto-increment.
    protected $keyType = 'int'; // Ensure the key type matches the API-provided ID.

    protected $fillable = [
        'id', 'player_id', 'team_id', 'season_id', 'position_id', 'jersey_number', 'has_values'
    ];

    public function details()
    {
        return $this->hasMany(StatlDetail::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
