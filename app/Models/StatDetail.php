<?php

namespace App\Models;

use App\Models\Statistic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatDetail extends Model
{
    use HasFactory;
    public $incrementing = false; // Disable auto-increment.
    protected $keyType = 'int'; // Ensure the key type matches the API-provided ID.

    protected $fillable = [
        'id', 'player_statistic_id', 'type_id', 'value'
    ];

    protected $casts = [
        'value' => 'array', // Treat the value column as JSON.
    ];

    public function statistic()
    {
        return $this->belongsTo(Statistic::class, 'player_statistic_id');
    }
}
