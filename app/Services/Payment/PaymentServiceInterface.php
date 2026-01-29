<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Payment;

interface PaymentServiceInterface
{
    /**
     * Create a payment intent/order with the gateway
     */
    public function createPayment(Order $order, array $options = []): array;

    /**
     * Process the payment
     */
    public function processPayment(Payment $payment, array $data = []): array;

    /**
     * Verify payment status with gateway
     */
    public function verifyPayment(Payment $payment): array;

    /**
     * Handle webhook from payment gateway
     */
    public function handleWebhook(array $data): array;

    /**
     * Refund a payment
     */
    public function refundPayment(Payment $payment, float $amount = null): array;

    /**
     * Get payment status from gateway
     */
    public function getPaymentStatus(string $gatewayPaymentId): array;
}