<?php

namespace App\Models;

use App\Models\PollOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Poll extends Model
{
    protected $guarded = ['id'];
    use HasFactory;
    public function options()
    {
        return $this->hasMany(PollOption::class);
    }
}
