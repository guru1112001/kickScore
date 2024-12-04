<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Group;
use App\Models\Country;
use Illuminate\Http\Request;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use App\Events\GroupCreated;

class GroupController extends Controller
{
    public function createGroup(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'schedule_start' => 'required|date_format:Y-m-d H:i:s',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'schedule_start' => $request->schedule_start,
            'created_by' => $request->user()->id, // Store the creator's ID
            'is_active' => true,
        ]);
        event(new GroupCreated($group));

        return response()->json(['group' => $group], 201);
    }

    public function toggleGroupStatus(Request $request, Group $group) {
        // Validate the request to ensure `is_active` is a boolean
        $request->validate([
            'is_active' => 'required|boolean',
        ]);
    
        // Check if the authenticated user is the creator
        if ($request->user()->id !== $group->created_by) {
            return response()->json(['error' => 'Only the group creator can update the status'], 403);
        }
    
        // Set the group's `is_active` status to the provided value
        $group->is_active = $request->is_active;
        $group->save();
        
        $group->users->each(function ($user) use ($group) {
            Notification::make()
                ->title('Group Status Changed')
                ->body("The group '{$group->name}' has been " . ($group->is_active ? 'activated' : 'deactivated') . ".")
                ->success()
                ->sendToDatabase($user); // Using `sendToDatabase` to send to the user
        });
    
    
        return response()->json(['group' => $group]);
    }
    

    public function getAllGroups() {
        $groups = Group::scheduled()
                        // ->where('is_active', true)
                        ->with('users:id,name,avatar_url')
                        ->get()
                        ->map(function ($group) {
                            $group->users = $group->users->map(function ($user) {
                                $user->formatted_avatar_url = $user->formatted_avatar_url;
                                return $user;
                            });
                            return $group;
                        });

        return response()->json(['groups' => $groups]);
    }


    public function searchGroups(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $groups = Group::where('name', 'like', '%' . $request->name . '%')
                    //    ->where('is_active',true)
                       ->with('users:id,name,avatar_url')
                       ->get()
                       ->map(function($group){
                        $group->users = $group->users->map(function ($user) {
                            $user->formatted_avatar_url = $user->formatted_avatar_url;
                            return $user;
                        });
                        return $group;
                       });
    
        return response()->json(['groups' => $groups]);
    }

    public function filterGroupsByCountry(Request $request) {
        $request->validate([
            'country_ids' => 'required|array',             // Ensure it's an array
            'country_ids.*' => 'integer|exists:countries,id', // Validate each ID exists in the countries table
        ]);
    
        // Retrieve groups where the creator's country matches any of the provided country IDs
        $groups = Group::whereHas('creator', function ($query) use ($request) {
                            $query->whereIn('country_id', $request->country_ids);
                        })
                        // ->where('is_active', true)
                        ->with('users:id,name,avatar_url') // Include users with selected fields
                        ->get()
                        ->map(function ($group) {
                            // Format avatar URLs for users
                            $group->users = $group->users->map(function ($user) {
                                $user->formatted_avatar_url = $user->formatted_avatar_url;
                                return $user;
                            });
                            return $group;
                        });
    
        if ($groups->isEmpty()) {
            return response()->json(['message' => 'Rooms not available'], 200);
        }
    
        return response()->json(['groups' => $groups]);
    }
    
    
}
