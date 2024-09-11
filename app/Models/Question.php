<?php

namespace App\Models;

use App\Models\Option;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function question_bank_type()
    {
        return $this->belongsTo(QuestionBankType::class, 'question_type');
    }
}
