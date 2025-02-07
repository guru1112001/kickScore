<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use App\Services\FirebaseService;

class SendPendingNotifications extends Command
{
    protected $signature = 'notifications:send-pending';
    protected $description = 'Send pending notifications via Firebase';
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        parent::__construct();
        $this->firebaseService = $firebaseService;
    }

    public function handle()
    {
        $limit = 10; // Limit to 10 notifications per run
        $pendingNotifications = Notification::whereNull('sended_at')
            ->whereHas('notifiable', function ($query) {
                $query->whereNotNull('fcm_token');
            })
            ->with('notifiable')
            ->take($limit)
            ->get();

        $count = 0;

        foreach ($pendingNotifications as $notification) {
            $user = $notification->notifiable;

            if ($user && $user->fcm_token) {
                // Log::info('Processing notification', ['user_id' => $user->id]);

                $notificationData = json_decode($notification->data, true);
                $title = $notificationData['title'] ?? 'New Notification';
                $body = $notificationData['body'] ?? 'You have a new notification';
                $data = $notificationData['data'] ?? [];

                try {
                    $success = $this->firebaseService->sendNotification(
                        $user->fcm_token,
                        $title,
                        $body,
                        $data
                    );

                    if ($success) {
                        $notification->sended_at = now();
                        $notification->save();
                        // Log::info("Notification sent successfully to user {$user->name}");
                    } else {
                        // Log::error("Failed to send notification", [
                        //     'user_id' => $user->id,
                        //     'fcm_token' => $user->fcm_token,
                        //     'title' => $title,
                        //     'body' => $body,
                        //     'data' => $data,
                        // ]);
                    }
                } catch (\Exception $e) {
                    // Log::error("Error sending notification", [
                    //     'user_id' => $user->id,
                    //     'error' => $e->getMessage(),
                    // ]);
                }
            } else {
                // Log::warning("No FCM token for user {$notification->notifiable_id}");
            }

            $count++;
            if ($count >= $limit) {
                break;
            }
        }

        // Log::info("Processed {$count} notifications");
    }
}
