<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function joinGroup(Request $request, $groupId) {
        $user = User::find($request->user_id);
        $group = Group::findOrFail($groupId);
        $group->users()->syncWithoutDetaching([$user->id]);
        return response()->json(['message' => 'User joined the group.']);
    }

    public function leaveGroup(Request $request, $groupId) {
        $user = User::find($request->user_id);
        $group = Group::findOrFail($groupId);
        $group->users()->detach($user->id);
        return response()->json(['message' => 'User left the group.']);
    }

    public function sendMessage(Request $request, $groupId) {
        $user = User::find($request->user_id);
        $message = Message::create([
            'group_id' => $groupId,
            'user_id' => $user->id,
            'content' => $request->content,
        ]);
        return response()->json(['message' => $message->load('user')]);
    }

    public function getOldMessages($groupId) {
        $messages = Message::where('group_id', $groupId)
                           ->with('user')
                           ->get();
        return response()->json(['messages' => $messages]);
    }

}
