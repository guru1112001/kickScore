<?php

namespace App\Models;

use App\Models\Option;
use App\Models\QuestionBank;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function questionBank()
{
    return $this->belongsTo(QuestionBank::class);
}

public function options()
{
    return $this->hasMany(Option::class);
}
}
