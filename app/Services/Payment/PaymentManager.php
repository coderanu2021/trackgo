<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentGateway;
use Exception;

class PaymentManager
{
    protected $gateways = [];

    public function __construct()
    {
        // Register available payment gateways
        $this->registerGateway('razorpay', RazorpayService::class);
        $this->registerGateway('stripe', StripeService::class);
        $this->registerGateway('paypal', PayPalService::class);
        $this->registerGateway('manual', ManualPaymentService::class);
    }

    public function registerGateway(string $name, string $serviceClass)
    {
        $this->gateways[$name] = $serviceClass;
    }

    public function getGateway(string $name): PaymentServiceInterface
    {
        if (!isset($this->gateways[$name])) {
            throw new Exception("Payment gateway '{$name}' not found");
        }

        $serviceClass = $this->gateways[$name];
        
        if (!class_exists($serviceClass)) {
            throw new Exception("Payment service class '{$serviceClass}' not found");
        }

        return new $serviceClass();
    }

    public function getAvailableGateways(string $currency = 'INR', float $amount = null): array
    {
        $query = PaymentGateway::active()->forCurrency($currency);

        if ($amount) {
            $query->where('min_amount', '<=', $amount)
                  ->where(function ($q) use ($amount) {
                      $q->whereNull('max_amount')
                        ->orWhere('max_amount', '>=', $amount);
                  });
        }

        return $query->orderBy('sort_order')->get()->toArray();
    }

    public function createPayment(Order $order, string $gateway, array $options = []): Payment
    {
        $gatewayModel = PaymentGateway::where('slug', $gateway)->firstOrFail();
        
        if (!$gatewayModel->isActive()) {
            throw new Exception("Payment gateway '{$gateway}' is not active");
        }

        if (!$gatewayModel->supportsCurrency($order->currency ?? 'INR')) {
            throw new Exception("Payment gateway '{$gateway}' does not support currency");
        }

        if (!$gatewayModel->supportsAmount($order->total_amount)) {
            throw new Exception("Payment amount is outside gateway limits");
        }

        // Create payment record
        $payment = Payment::create([
            'order_id' => $order->id,
            'gateway' => $gateway,
            'amount' => $order->total_amount,
            'currency' => $order->currency ?? 'INR',
            'status' => 'pending',
            'metadata' => $options
        ]);

        // Create payment with gateway
        $service = $this->getGateway($gateway);
        $result = $service->createPayment($order, $options);

        // Update payment with gateway response
        $payment->update([
            'gateway_payment_id' => $result['gateway_payment_id'] ?? null,
            'gateway_response' => $result
        ]);

        return $payment;
    }

    public function processPayment(Payment $payment, array $data = []): array
    {
        $service = $this->getGateway($payment->gateway);
        return $service->processPayment($payment, $data);
    }

    public function verifyPayment(Payment $payment): array
    {
        $service = $this->getGateway($payment->gateway);
        return $service->verifyPayment($payment);
    }

    public function handleWebhook(string $gateway, array $data): array
    {
        $service = $this->getGateway($gateway);
        return $service->handleWebhook($data);
    }
}