<?php

namespace App\Services\Mandiri;

use Illuminate\Support\Facades\Http;

class MandiriAuthService
{
    public function getAccessToken(): string
    {
        $timestamp = now()->format('Y-m-d\TH:i:sP');
        $clientKey = config('mandiri.client_key');
        $clientSecret = config('mandiri.client_secret');
        $baseUrl = config('mandiri.base_url');

        $stringToSign = $clientKey . '|' . $timestamp;
        openssl_sign($stringToSign, $signature, $clientSecret, OPENSSL_ALGO_SHA256);
        $signature = base64_encode($signature);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-TIMESTAMP' => $timestamp,
            'X-CLIENT-KEY' => $clientKey,
            'X-SIGNATURE' => $signature,
        ])->post($baseUrl . '/openapi/auth/v1.0/access-token/b2b', [
            'grantType' => 'client_credentials',
        ]);

        if (!$response->successful()) {
            throw new \Exception('Gagal ambil access token Mandiri: ' . $response->body());
        }

        return $response->json('accessToken');
    }
}