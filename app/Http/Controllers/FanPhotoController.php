<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\FanPhoto;
use Illuminate\Http\Request;

class FanPhotoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            'caption' => 'required|string',
            'acknowledge' => 'required',
        ]);

        $imagePath = $request->file('image')->store('', 'public');

        $fanPhoto = FanPhoto::create([
            'image' => $imagePath,
            'caption' => $request->caption,
            'acknowledge' => $request->acknowledge,
            'status' => 'draft', // By default, set as 'draft'
            'user_id' => auth()->id(),
        ]);

        return response()->json($fanPhoto, 201);
    }

    public function index()
    {
        $user_id = auth()->id(); // Get the logged-in user's ID

        $photos = FanPhoto::where('status', 'approved')
            ->with('user') // Load full user details (no select constraint)
            ->get()
            ->map(function ($photo) use ($user_id) {
                $photo->image = $photo->image ? url('storage/' . $photo->image) : null;
                $photo->claps_count = $photo->clapsCount();
                $photo->likes_count = $photo->likesCount();
                $photo->hearts_count = $photo->heartsCount();

                // Get the reaction type (like, clap, or heart) if the user has reacted
                $reaction = Like::where('user_id', $user_id)
                    ->where('fan_photo_id', $photo->id)
                    ->first();

                $photo->is_reacted = $reaction ? $reaction->reaction_type : null;

                return $photo;
            });

        return $photos; // Laravel will automatically convert this to JSON
    }

    
public function reactToFanPhoto(Request $request, $id)
    {
        $request->validate([
            // 'user_id' => 'required|exists:users,id', // Validate user existence
            'reaction_type' => 'required|in:clap,like,heart', // Validate reaction type
        ]);

        // Check if the fan photo exists
        $fanPhoto = FanPhoto::findOrFail($id);

        $user_id=auth()->id();
        // Check if the user has already reacted to the fan photo
        $existingReaction = Like::where('user_id', $user_id)
            ->where('fan_photo_id', $fanPhoto->id)
            ->first();

        // If the user has already reacted, remove the previous reaction
        if ($existingReaction) {
            $existingReaction->delete();
        }

        // Add the new reaction
        Like::create([
            'user_id' => $user_id,
            'fan_photo_id' => $fanPhoto->id,
            'reaction_type' => $request->reaction_type,
        ]);

        return response()->json(['message' => 'Reaction added successfully'], 201);
    }

    // Remove a reaction from a fan photo
    public function removeReaction(Request $request, $id)
    {
        $request->validate([
            // 'user_id' => 'required|exists:users,id',
            'reaction_type' => 'required|in:clap,like,heart',
        ]);
        $user_id=auth()->id();
        // Find the user's reaction and delete it
        $reaction = Like::where('user_id', $user_id)
            ->where('fan_photo_id', $id)
            ->where('reaction_type', $request->reaction_type)
            ->first();

        if (!$reaction) {
            return response()->json(['message' => 'Reaction not found'], 404);
        }

        $reaction->delete();

        return response()->json(['message' => 'Reaction removed successfully'], 200);
    }


    public function leaderboard()
{
    $topPhotos = FanPhoto::where('status', 'approved')
        ->with('user') // Load user relationship
        ->withCount('likes') // Count the likes for each photo
        ->orderBy('likes_count', 'desc') // Sort by likes count in descending order
        ->limit(5) // Get top 5
        ->get()
        ->map(function ($photo) {
            $photo->image = $photo->image ? url('storage/' . $photo->image) : null;
            $photo->likes_count = $photo->likesCount(); // Get exact count
            $photo->claps_count = $photo->clapsCount();
            $photo->hearts_count = $photo->heartsCount();
            $photo->username = $photo->user->name ?? 'unknown'; // Assuming your User model has a 'name' field
            
            // Optionally unset the full user object if you only want the username
            unset($photo->user);
            
            return $photo;
        });

    return response()->json([
        'leaderboard' => $topPhotos,
        'timestamp' => now()
    ]);
}
    // public function approve(FanPhoto $fanPhoto)
    // {
    //     $fanPhoto->update(['status' => 'approved']);
    //     return response()->json(['message' => 'Photo approved']);
    // }

    // public function reject(FanPhoto $fanPhoto)
    // {
    //     $fanPhoto->update(['status' => 'rejected']);
    //     return response()->json(['message' => 'Photo rejected']);
    // }
}
