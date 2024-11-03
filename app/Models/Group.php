<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function users() {
        return $this->belongsToMany(User::class);
    }
    
    public function messages() {
        return $this->hasMany(Message::class);
    }

    public function scopeScheduled($query) {
        return $query->where('is_scheduled', true)
                     ->where('schedule_start', '<=', now())
                     ->where('schedule_end', '>=', now());
    }

}
