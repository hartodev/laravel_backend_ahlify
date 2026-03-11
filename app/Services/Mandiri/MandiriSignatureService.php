<?php

namespace App\Services\Mandiri;

class MandiriSignatureService
{
    public function createTransactionSignature(
        string $httpMethod,
        string $endpointUrl,
        string $accessToken,
        array $body,
        string $timestamp
    ): string {
        $minifiedBody = json_encode($body, JSON_UNESCAPED_SLASHES);
        $bodyHash = strtolower(hash('sha256', $minifiedBody));

        $stringToSign = implode(':', [
            strtoupper($httpMethod),
            $endpointUrl,
            $accessToken,
            $bodyHash,
            $timestamp,
        ]);

        return base64_encode(hash_hmac('sha512', $stringToSign, config('mandiri.client_secret'), true));
    }
}