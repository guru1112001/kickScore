<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class GroupController extends Controller
{
    public function createGroup(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'schedule_start' => 'required|date_format:Y-m-d H:i:s', // Ensuring both date and time
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $group = Group::create($validator->validated());
    
        return response()->json(['group' => $group], 201);
    }

    public function getAllGroups() {
        $groups = Group::scheduled()->with('users:id,name,avatar_url')->get();
        $groups = $groups->map(function ($group) {
            $group->users = $group->users->map(function ($user) {
                $user->formatted_avatar_url = $user->formatted_avatar_url; // Accessor provides the formatted URL
                return $user;
            });
            return $group;
        });
    
        return response()->json(['groups' => $groups]);
    }
}
