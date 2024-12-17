<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sportmonkteam extends Model
{
    use HasFactory;
    public $incrementing = false; // Disable auto-incrementing for the primary key
    protected $keyType = 'int';   // Define the primary key as integer

    protected $fillable = [
        'id',
        'sport_id',
        'country_id',
        'venue_id',
        'gender',
        'name',
        'short_code',
        'image_path',
        'founded',
        'type',
        'placeholder',
        'last_played_at',
    ];
}
