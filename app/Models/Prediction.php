<?php

namespace App\Models;

use App\Models\LiveFixture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prediction extends Model
{
    use HasFactory;
    protected $fillable = ['fixture_id', 'prediction'];
    protected $cast=['prediction'=>'json'];
    public function fixture()
    {
        return $this->belongsTo(LiveFixture::class, 'fixture_id');
    }
}
