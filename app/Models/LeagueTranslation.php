<?php

namespace App\Models;

use App\Models\League;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeagueTranslation extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    public function league()
    {
        return $this->belongsTo(League::class,'league_id');
    }
}
