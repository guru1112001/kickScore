<?php

namespace App\Models;

use App\Models\Poll;
use App\Models\PollVote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PollOption extends Model
{
    protected $guarded = ['id'];
    use HasFactory;


    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }


    public function votes()
    {
        return $this->hasMany(PollVote::class,'option_id');
    }
}
