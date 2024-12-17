<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    public $incrementing = false; // Disable auto-increment for the primary key
    protected $keyType = 'int';  // Ensure the primary key is treated as an integer

    protected $fillable = [
        'id', // Use API-provided ID as the primary key
        'name',
        'code',
        'developer_name',
        'stat_group',
        'model_type',
    ];
}
