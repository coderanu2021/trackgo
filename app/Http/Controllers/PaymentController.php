<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentGateway;
use App\Services\Payment\PaymentManager;
use Illuminate\Http\Request;
use Exception;

class PaymentController extends Controller
{
    protected $paymentManager;

    public function __construct(PaymentManager $paymentManager)
    {
        $this->paymentManager = $paymentManager;
    }

    public function showPaymentMethods(Order $order)
    {
        $gateways = $this->paymentManager->getAvailableGateways('INR', $order->total_amount);
        
        return view('front.payment.methods', compact('order', 'gateways'));
    }

    public function initiatePayment(Request $request, Order $order)
    {
        $request->validate([
            'gateway' => 'required|string|exists:payment_gateways,slug'
        ]);

        try {
            $payment = $this->paymentManager->createPayment(
                $order, 
                $request->gateway,
                $request->only(['return_url', 'cancel_url'])
            );

            // If gateway provides checkout URL, redirect there
            $gatewayResponse = $payment->gateway_response;
            if (isset($gatewayResponse['checkout_url'])) {
                return redirect($gatewayResponse['checkout_url']);
            }

            // Otherwise, show payment page (for gateways like Razorpay that use JS)
            return view('front.payment.process', compact('payment', 'order'));

        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function processPayment(Request $request, Payment $payment)
    {
        try {
            $result = $this->paymentManager->processPayment($payment, $request->all());

            if ($result['success']) {
                return redirect()->route('payment.success', $payment)
                    ->with('success', 'Payment completed successfully!');
            } else {
                return redirect()->route('payment.failed', $payment)
                    ->with('error', $result['message'] ?? 'Payment failed');
            }

        } catch (Exception $e) {
            return redirect()->route('payment.failed', $payment)
                ->with('error', $e->getMessage());
        }
    }

    public function success(Payment $payment)
    {
        return view('front.payment.success', compact('payment'));
    }

    public function failed(Payment $payment)
    {
        return view('front.payment.failed', compact('payment'));
    }

    public function webhook(Request $request, $gateway)
    {
        try {
            $result = $this->paymentManager->handleWebhook($gateway, $request->all());
            
            return response()->json([
                'success' => $result['success'],
                'message' => $result['message'] ?? 'Webhook processed'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function verify(Request $request, Payment $payment)
    {
        try {
            $result = $this->paymentManager->verifyPayment($payment);
            
            return response()->json($result);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
