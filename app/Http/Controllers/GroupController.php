<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GroupController extends Controller
{
    public function createGroup(Request $request) {
        $group = Group::create([
            'name' => $request->name,
            'is_scheduled' => $request->is_scheduled,
            'schedule_start' => $request->schedule_start,
            'schedule_end' => $request->schedule_end
        ]);
        return response()->json(['group' => $group], 201);
    }

    public function getAllGroups() {
        $groups = Group::scheduled()->with('users')->get();
        return response()->json(['groups' => $groups]);
    }
}
