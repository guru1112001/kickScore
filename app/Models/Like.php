<?php

namespace App\Models;

use App\Models\Post;
use App\Models\User;
use App\Models\FanPhoto;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['user_id', 'fan_photo_id', 'reaction_type'];
    // Define relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A like belongs to a fan photo
    public function fanPhoto()
    {
        return $this->belongsTo(FanPhoto::class);
    }
   
}
