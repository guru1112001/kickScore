<?php

namespace App\Models;

use App\Models\User;
use App\Models\PollOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PollVote extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    
    public function option()
    {
        return $this->belongsTo(PollOption::class);
    }

    // A PollVote belongs to a User (if you're tracking user votes)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
