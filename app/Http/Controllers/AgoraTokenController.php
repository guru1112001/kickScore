<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TaylanUnutmaz\AgoraTokenBuilder\RtcTokenBuilder;

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
    
}
