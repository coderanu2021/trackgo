<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Payment;
use Exception;

class ManualPaymentService implements PaymentServiceInterface
{
    public function createPayment(Order $order, array $options = []): array
    {
        // Manual payment (Bank Transfer, Cash on Delivery, etc.)
        return [
            'success' => true,
            'gateway_payment_id' => 'MANUAL_' . uniqid(),
            'message' => 'Manual payment order created',
            'instructions' => $options['instructions'] ?? 'Please complete payment as instructed'
        ];
    }

    public function processPayment(Payment $payment, array $data = []): array
    {
        // Manual verification by admin
        $payment->update([
            'status' => 'processing',
            'gateway_response' => $data
        ]);

        return [
            'success' => true,
            'message' => 'Manual payment submitted for verification'
        ];
    }

    public function verifyPayment(Payment $payment): array
    {
        return [
            'success' => true,
            'status' => $payment->status,
            'message' => 'Manual payment status retrieved'
        ];
    }

    public function handleWebhook(array $data): array
    {
        // No webhooks for manual payments
        return ['success' => true, 'message' => 'No webhook handling needed'];
    }

    public function refundPayment(Payment $payment, float $amount = null): array
    {
        return [
            'success' => true,
            'message' => 'Manual refund initiated - admin will process'
        ];
    }

    public function getPaymentStatus(string $gatewayPaymentId): array
    {
        return ['success' => true, 'status' => 'pending_verification'];
    }
}