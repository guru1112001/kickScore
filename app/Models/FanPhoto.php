<?php

namespace App\Models;

use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FanPhoto extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $casts = [
        'acknowledge' => 'boolean',
    ];
    public function clapsCount()
{
    return $this->likes()->where('reaction_type', 'clap')->count();
}

public function likesCount()
{
    return $this->likes()->where('reaction_type', 'like')->count();
}

public function heartsCount()
{
    return $this->likes()->where('reaction_type', 'heart')->count();
}
public function likes()
{
    return $this->hasMany(Like::class);
}
}
