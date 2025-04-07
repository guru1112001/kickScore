<?php

namespace App\Models;

use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Notifications\Notification;

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

public function likesRelation()  // Changed name to avoid conflict
    {
        return $this->likes()->where('reaction_type', 'like');
    }

// Define specific reaction relationships
public function claps()
{
    return $this->likes()->where('reaction_type', 'clap');
}

public function hearts()
    {
        return $this->likes()->where('reaction_type', 'heart');
    }
protected static function boot()
{
    parent::boot();

    static::updated(function ($photo) {
        if ($photo->isDirty('status')) { // Check if 'status' field changed
            $status = ucfirst($photo->status);
            $message = "Your photo \"{$photo->caption}\" has been {$status}.";

            if ($photo->user) {
                Notification::make()
                    ->title("Photo {$status}")
                    ->body($message)
                    ->sendToDatabase($photo->user);
            }
        }
    });
}
}
