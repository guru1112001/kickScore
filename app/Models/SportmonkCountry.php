<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SportmonkCountry extends Model
{
    use HasFactory;
    // protected $table = 'sportmonkcountry'; // Explicitly set the table name.
    public $incrementing = false; // ID is not auto-incremented.
    protected $keyType = 'int'; // Primary key is an integer.

    protected $fillable = [
        'id',
        'continent_id',
        'name',
        'official_name',
        'fifa_name',
        'iso2',
        'iso3',
        'latitude',
        'longitude',
        'geonameid',
        'border',
        'image_path',
    ];
}
