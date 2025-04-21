<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;

class PaymentService
{
    protected $clientId;
    protected $clientSecret;
    protected $mode;

    public function __construct()
    {
        $this->clientId = config('paypal.sandbox.client_id');
        $this->clientSecret = config('paypal.sandbox.client_secret');
        $this->mode = config('paypal.mode');
    }

    public function getAccessToken()
    {
        $url = $this->mode === 'sandbox'
            ? 'https://api-m.sandbox.paypal.com/v1/oauth2/token'
            : 'https://api-m.paypal.com/v1/oauth2/token';

        $response = Http::withBasicAuth($this->clientId, $this->clientSecret)
            ->asForm()
            ->post($url, [
                'grant_type' => 'client_credentials'
            ]);

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        throw new \Exception('Failed to get PayPal access token');
    }

    public function createOrder(Order $order)
    {
        $accessToken = $this->getAccessToken();

        $url = $this->mode === 'sandbox'
            ? 'https://api-m.sandbox.paypal.com/v2/checkout/orders'
            : 'https://api-m.paypal.com/v2/checkout/orders';

        $response = Http::withToken($accessToken)
            ->post($url, [
                'intent' => 'CAPTURE',
                'application_context' => [
                    'return_url' => route('payment.success'),
                    'cancel_url' => route('payment.cancel'),
                ],
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => 'USD',
                            'value' => number_format($order->total_amount, 2, '.', '')
                        ]
                    ]
                ]
            ]);

        if ($response->successful()) {
            $data = $response->json();
            foreach ($data['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return $link['href'];
                }
            }
        }

        throw new \Exception('Failed to create PayPal order');
    }

    public function capturePayment($orderId)
    {
        $accessToken = $this->getAccessToken();

        $url = $this->mode === 'sandbox'
            ? "https://api-m.sandbox.paypal.com/v2/checkout/orders/{$orderId}/capture"
            : "https://api-m.paypal.com/v2/checkout/orders/{$orderId}/capture";

        $response = Http::withToken($accessToken)
            ->post($url);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Failed to capture PayPal payment');
    }
}
