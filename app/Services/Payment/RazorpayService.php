<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentGateway;
use Exception;

class RazorpayService implements PaymentServiceInterface
{
    protected $gateway;
    protected $keyId;
    protected $keySecret;
    protected $isTestMode;

    public function __construct()
    {
        $this->gateway = PaymentGateway::where('slug', 'razorpay')->first();
        
        if ($this->gateway) {
            $config = $this->gateway->getConfig();
            $this->keyId = $config['key_id'] ?? null;
            $this->keySecret = $config['key_secret'] ?? null;
            $this->isTestMode = $this->gateway->is_test_mode;
        }
    }

    public function createPayment(Order $order, array $options = []): array
    {
        try {
            // In a real implementation, you would use Razorpay SDK
            // For now, we'll simulate the response
            
            $orderId = 'order_' . uniqid();
            
            // Simulate Razorpay order creation
            $razorpayOrder = [
                'id' => $orderId,
                'amount' => $order->total_amount * 100, // Razorpay uses paise
                'currency' => 'INR',
                'status' => 'created',
                'receipt' => $order->id,
                'notes' => [
                    'order_id' => $order->id,
                    'customer_name' => $order->customer_name,
                    'customer_email' => $order->customer_email
                ]
            ];

            return [
                'success' => true,
                'gateway_payment_id' => $orderId,
                'payment_data' => $razorpayOrder,
                'checkout_url' => null, // Razorpay uses JS checkout
                'message' => 'Razorpay order created successfully'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Failed to create Razorpay order'
            ];
        }
    }

    public function processPayment(Payment $payment, array $data = []): array
    {
        try {
            // Verify payment signature (in real implementation)
            $razorpayPaymentId = $data['razorpay_payment_id'] ?? null;
            $razorpayOrderId = $data['razorpay_order_id'] ?? null;
            $razorpaySignature = $data['razorpay_signature'] ?? null;

            if (!$razorpayPaymentId || !$razorpayOrderId || !$razorpaySignature) {
                throw new Exception('Missing required Razorpay parameters');
            }

            // In real implementation, verify signature using Razorpay SDK
            // $api = new \Razorpay\Api\Api($this->keyId, $this->keySecret);
            // $api->utility->verifyPaymentSignature($data);

            // Update payment status
            $payment->update([
                'status' => 'completed',
                'gateway_payment_id' => $razorpayPaymentId,
                'paid_at' => now(),
                'gateway_response' => $data
            ]);

            // Update order status
            $payment->order->update([
                'payment_status' => 'completed',
                'payment_method' => 'razorpay',
                'transaction_id' => $razorpayPaymentId,
                'payment_details' => $data
            ]);

            return [
                'success' => true,
                'payment_id' => $razorpayPaymentId,
                'message' => 'Payment completed successfully'
            ];

        } catch (Exception $e) {
            $payment->update([
                'status' => 'failed',
                'gateway_response' => ['error' => $e->getMessage()]
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Payment verification failed'
            ];
        }
    }

    public function verifyPayment(Payment $payment): array
    {
        try {
            // In real implementation, fetch payment details from Razorpay
            // $api = new \Razorpay\Api\Api($this->keyId, $this->keySecret);
            // $razorpayPayment = $api->payment->fetch($payment->gateway_payment_id);

            // Simulate verification
            return [
                'success' => true,
                'status' => $payment->status,
                'message' => 'Payment verified successfully'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Payment verification failed'
            ];
        }
    }

    public function handleWebhook(array $data): array
    {
        try {
            // Handle Razorpay webhooks
            $event = $data['event'] ?? null;
            $paymentData = $data['payload']['payment']['entity'] ?? null;

            if ($event === 'payment.captured' && $paymentData) {
                $payment = Payment::where('gateway_payment_id', $paymentData['order_id'])->first();
                
                if ($payment) {
                    $payment->update([
                        'status' => 'completed',
                        'paid_at' => now(),
                        'gateway_response' => $paymentData
                    ]);

                    $payment->order->update([
                        'payment_status' => 'completed'
                    ]);
                }
            }

            return [
                'success' => true,
                'message' => 'Webhook processed successfully'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Webhook processing failed'
            ];
        }
    }

    public function refundPayment(Payment $payment, float $amount = null): array
    {
        try {
            // In real implementation, create refund via Razorpay API
            $refundAmount = $amount ?? $payment->amount;

            return [
                'success' => true,
                'refund_id' => 'rfnd_' . uniqid(),
                'amount' => $refundAmount,
                'message' => 'Refund initiated successfully'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Refund failed'
            ];
        }
    }

    public function getPaymentStatus(string $gatewayPaymentId): array
    {
        try {
            // In real implementation, fetch from Razorpay API
            return [
                'success' => true,
                'status' => 'captured',
                'message' => 'Payment status retrieved successfully'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Failed to get payment status'
            ];
        }
    }
}