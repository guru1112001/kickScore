<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leaderboard extends Model
{
    use HasFactory;

    protected $table = "leaderboard";
    public $rank = 0;  // Temporary property to hold rank
    protected $primaryKey = 'user_id'; // Only if your view has a primary key

    public function getFormattedWeightedScoreAttribute()
    {
        return round($this->weighted_score, 2);
    }


    public function getRankAttribute()
    {
        return $this->rank;
    }

}
