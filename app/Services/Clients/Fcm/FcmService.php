<?php

namespace App\Services\Clients\Fcm;
use Google\Auth\OAuth2;
use Illuminate\Support\Facades\Http;

class FcmService
{
    public function sendNotification($token, $title, $body): void
    {
        $keyFile = storage_path("app/key-fcm.json");
        $jsonKey = json_decode(file_get_contents($keyFile), true);

        $oauth = new OAuth2([
            'audience' => 'https://oauth2.googleapis.com/token',
            'issuer' => $jsonKey['client_email'],
            'signingAlgorithm' => 'RS256',
            'signingKey' => $jsonKey['private_key'],
            'tokenCredentialUri' => $jsonKey['token_uri'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
        ]);

        $tokenResponse = $oauth->fetchAuthToken();
        $accessToken = $tokenResponse['access_token'];
        $projectId = $jsonKey['project_id'];

        Http::withToken($accessToken)->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
            ]
        ]);
    }
}
