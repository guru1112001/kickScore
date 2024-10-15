<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function question()
{
    return $this->belongsTo(Question::class);
}
protected $casts = [
    'is_correct' => 'boolean',  // Cast is_correct as boolean
];
}
