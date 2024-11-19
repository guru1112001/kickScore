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
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function users() {
        return $this->belongsToMany(User::class);
    }
    
    public function messages() {
        return $this->hasMany(Message::class);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeScheduled($query) {
    return $query->where('schedule_start', '<=', Carbon::now());
    }

}
