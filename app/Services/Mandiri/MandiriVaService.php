<?php

namespace App\Services\Mandiri;

use App\Models\Payment;
use App\Models\PaymentVirtualAccount;
use Illuminate\Support\Facades\Http;

class MandiriVaService
{
    public function __construct(
        protected MandiriAuthService $authService,
        protected MandiriSignatureService $signatureService
    ) {}

    public function createVa(Payment $payment): PaymentVirtualAccount
    {
        $payment->load('customer', 'serviceOrder');

        $accessToken = $this->authService->getAccessToken();
        $timestamp = now()->format('Y-m-d\TH:i:sP');
        $endpoint = '/openapi/transaction/v1.0/transfer-va/create-va';
        $externalId = (string) random_int(100000000000000000, 999999999999999999);

        $partnerServiceId = config('mandiri.partner_service_id');
        $customerNo = str_pad((string) $payment->customer_id, 10, '0', STR_PAD_LEFT);
        $virtualAccountNo = $partnerServiceId . $customerNo;
        $trxId = $payment->payment_code;
        $expiredDate = now()->addDay()->format('Y-m-d\TH:i:sP');

        $body = [
            'partnerServiceId' => (string) $partnerServiceId,
            'customerNo' => (string) $virtualAccountNo,
            'virtualAccountNo' => (string) $virtualAccountNo,
            'virtualAccountName' => $payment->customer->name,
            'virtualAccountEmail' => $payment->customer->email,
            'virtualAccountPhone' => $payment->customer->phone,
            'trxId' => $trxId,
            'totalAmount' => [
                'value' => number_format($payment->amount, 2, '.', ''),
                'currency' => 'IDR',
            ],
            'billDetails' => [
                [
                    'billAmount' => [
                        'value' => number_format($payment->amount, 2, '.', ''),
                        'currency' => 'IDR',
                    ],
                ],
            ],
            'expiredDate' => $expiredDate,
        ];

        $signature = $this->signatureService->createTransactionSignature(
            'POST',
            $endpoint,
            $accessToken,
            $body,
            $timestamp
        );

        $response = Http::withToken($accessToken)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'X-TIMESTAMP' => $timestamp,
                'X-SIGNATURE' => $signature,
                'X-PARTNER-ID' => config('mandiri.partner_id'),
                'X-EXTERNAL-ID' => $externalId,
            ])
            ->post(config('mandiri.base_url') . $endpoint, $body);

        if (!$response->successful()) {
            throw new \Exception('Create VA gagal: ' . $response->body());
        }

        $responseData = $response->json('virtualAccountData') ?? [];

        return PaymentVirtualAccount::create([
            'payment_id' => $payment->id,
            'partner_service_id' => $partnerServiceId,
            'customer_no' => $body['customerNo'],
            'virtual_account_no' => $responseData['virtualAccountNo'] ?? $body['virtualAccountNo'],
            'virtual_account_name' => $responseData['virtualAccountName'] ?? $body['virtualAccountName'],
            'virtual_account_email' => $responseData['virtualAccountEmail'] ?? $body['virtualAccountEmail'],
            'virtual_account_phone' => $responseData['virtualAccountPhone'] ?? $body['virtualAccountPhone'],
            'trx_id' => $responseData['trxId'] ?? $body['trxId'],
            'payment_type' => 'close',
            'total_amount' => $payment->amount,
            'currency' => 'IDR',
            'expired_date' => now()->addDay(),
            'raw_create_request' => $body,
            'raw_create_response' => $response->json(),
            'status' => 'pending',
        ]);
    }
}