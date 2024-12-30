<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    // protected $guarded = ['id'];
    public $incrementing = false; // Disable auto-increment for ID
    protected $keyType = 'int'; 
    protected $fillable = [
        'id',
        'country_id',
        'region',
        'name',
        'latitude',
        'longitude',
        'geonameid',
    ];
}
