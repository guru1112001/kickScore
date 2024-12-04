<?php

namespace App\Listeners;

use App\Events\GroupCreated;
use App\Models\GroupNotification;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class NotifyUsersInSameCountry
{
    public function handle(GroupCreated $event)
    {
        $group = $event->group;
        $countryId = $group->creator->Country_id; // Assuming Group has a relationship with the creator.

        // Check if a notification has already been sent today for this country
        $notificationExists = GroupNotification::where('country_id', $countryId)
            ->where('notification_date', today())
            ->exists();

        if ($notificationExists) {
            Log::info("Notification for country {$countryId} already sent today.");
            return;
        }

        // Find users in the same country
        $users = User::where('Country_id', $countryId)
            ->whereNotNull('fcm_token') // Ensure user has FCM token
            ->get();

        foreach ($users as $user) {
            // Send notification (assuming a FirebaseService exists)
            app('App\Services\FirebaseService')->sendNotification(
                $user->fcm_token,
                "New Group Created!",
                "A new group has been created in your region."
            );
        }

        // Log the notification as sent
        GroupNotification::create([
            'country_id' => $countryId,
            'notification_date' => today(),
        ]);

        Log::info("Notification sent to users in country {$countryId}.");
    }
}
