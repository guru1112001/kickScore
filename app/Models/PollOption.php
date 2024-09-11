<?php

namespace App\Models;

use App\Models\Poll;
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
}
