<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Filament\Notifications\Notification;
use TaylanUnutmaz\AgoraTokenBuilder\RtcTokenBuilder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class AgoraTokenController extends Controller
{
    /**
     * Generate Agora token.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateToken(Request $request)
    {
        $request->validate([
            'channel_name' => 'required|string|max:255',
            'uid' => 'required|integer',
            'role' => 'required|in:publisher,subscriber', // Define roles
            'group_id' => 'required|integer', // Add group_id validation
        ]);

        // Your Agora credentials
        $appId = config('services.agora_app_id');
        $appCertificate = config('services.agora_app_certificate');
        $channelName = $request->input('channel_name');
        $uid = $request->input('uid');
        $role = $request->input('role') === 'publisher' ? 1 : 2; // 1 for Publisher, 2 for Subscriber

        // Token expiration time in seconds (e.g., 1 hour)
        $expireTimeInSeconds = 3600;
        $currentTime = now()->timestamp;
        $privilegeExpiredTs = $currentTime + $expireTimeInSeconds;

        // Generate the token
        try {
            $token = RtcTokenBuilder::buildTokenWithUid(
                $appId,
                $appCertificate,
                $channelName,
                $uid,
                $role,
                $privilegeExpiredTs
            );

            // Send notification to all group users
            $this->notifyGroupUsers($request->input('group_id'), $channelName);

            return response()->json([
                'success' => true,
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token generation failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Notify all users in a group.
     *
     * @param int $groupId
     * @param string $channelName
     * @return void
     */

    private function notifyGroupUsers(int $groupId, string $channelName)
    {
        // Fetch all user IDs in the group
        $userIds = DB::table('group_user')
            ->where('group_id', $groupId)
            ->pluck('user_id');
    
        // Retrieve users as model instances
        $users = User::whereIn('id', $userIds)->get();
    
        // Notification data
        $notificationData = [
            'title' => "Group Call Started",
            'body' => "A group call has started in the channel '{$channelName}'. Join now!",
            'data'=>['channel_name' => $channelName,
            'group_id' => $groupId,
            'navigationId' => 'MeetingChat']
        ];
    
        // Send notifications to all users
        foreach ($users as $user) {
            FacadesNotification::send($user, new \App\Notifications\GroupCallNotification($notificationData));
        }
    }
    
}
