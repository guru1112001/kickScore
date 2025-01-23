<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        try {
            $firebase = (new Factory)->withServiceAccount(base_path(config('services.firebase.credentials')));
            $this->messaging = $firebase->createMessaging();
        } catch (\Exception $e) {
            // Log::error('Failed to initialize Firebase: ' . $e->getMessage());
        }
    }

    public function sendNotification($fcm_token, $title, $body, $data=[])
{
    if (!$this->messaging) {
        Log::error('Firebase Messaging not initialized');
        return false;
    }

    try {
        Log::info('Sending notification', ['fcm_token' => $fcm_token, 'title' => $title, 'body' => $body, 'data' => $data]);
        // Create a notification (without additional data)
        $notification = Notification::create($title, $body);

        // Create a cloud message with the notification and additional data
        $message = CloudMessage::withTarget('token', $fcm_token)
            ->withNotification($notification)
            ->withData($data); // Attach additional data
        Log::info('Sending notification', ['message' => $message]);

        // Send the notification
        $response = $this->messaging->send($message);
        Log::info('Notification sent successfully', ['response' => $response]);
        return true;
    } catch (\Exception $e) {
        Log::error('Failed to send notification: ' . $e->getMessage());
        return false;
    }
}

}