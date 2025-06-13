<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Google\Auth\OAuth2;
use Google\Auth\Credentials\ServiceAccountCredentials;


class FcmChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if (!$notifiable->fcm_token) {
            return;
        }

        $message = $notification->toFcm($notifiable);

        $credentialsPath = base_path(env('FIREBASE_CREDENTIALS'));
        $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];
        $credentials = new ServiceAccountCredentials($scopes, $credentialsPath);
        $accessToken = $credentials->fetchAuthToken()['access_token'];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post('https://fcm.googleapis.com/v1/projects/' . env('FIREBASE_PROJECT_ID') . '/messages:send', $message);

            if (!$response->successful()) {
                Log::error('FCM Error: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('FCM Exception: ' . $e->getMessage());
        }
    }
}
