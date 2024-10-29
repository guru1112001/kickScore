<?php

namespace App\Models;

use App\Models\User;
use App\Models\LeagueTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class League extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function users()
{
    return $this->belongsToMany(User::class, 'league_user');
}
public function translations()
{
    return $this->hasMany(LeagueTranslation::class, 'league_id', 'league_id');
}

    

}
