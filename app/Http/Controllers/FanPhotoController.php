<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FanPhoto;

class FanPhotoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            'caption' => 'required|string',
            'acknowledge' => 'required|boolean',
        ]);

        $imagePath = $request->file('image')->store('fan_photos', 'public');

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
        $photos = FanPhoto::where('status', 'approved')->with('user:id,name') // Include user name and id with each fan photo
        ->get();
        return response()->json($photos);
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
