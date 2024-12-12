<?php

namespace App\Models;

use App\Models\Statistic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory;
    public $incrementing = false; // Disable auto-increment.
    protected $keyType = 'int'; // Use 'int' since the primary key is an integer.

    protected $fillable = [
        'id', 'sport_id', 'country_id', 'nationality_id', 'city_id', 
        'position_id', 'detailed_position_id', 'type_id', 'common_name', 
        'firstname', 'lastname', 'name', 'display_name', 'image_path', 
        'height', 'weight', 'date_of_birth', 'gender'
    ];

    public function statistics()
    {
        return $this->hasMany(Statistic::class);
    }
}
