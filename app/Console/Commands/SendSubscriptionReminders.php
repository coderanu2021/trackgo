<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendSubscriptionReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily WhatsApp reminders to users whose subscription expires in less than 30 days.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expiring subscriptions...');
        
        $subscriptions = \App\Models\Subscription::where('status', 'active')
            ->whereDate('end_date', '>', now())
            ->whereDate('end_date', '<=', now()->addDays(30))
            ->with(['user', 'order'])
            ->get();

        if($subscriptions->isEmpty()) {
            $this->info('No expiring subscriptions found.');
            return;
        }

        foreach ($subscriptions as $sub) {
            $daysLeft = now()->diffInDays($sub->end_date, false);
            // $phone = $sub->order->customer_phone ?? $sub->user->phone ?? null; 
            // Using placeholder logic as we depend on Order/User having phone.
            
            $customerName = $sub->user->name ?? $sub->customer_name ?? $sub->order->customer_name ?? 'Customer';
            $phone = $sub->customer_phone ?? $sub->order->customer_phone ?? 'N/A';
            
            if ($phone === 'N/A') {
                $this->warn("Skipping subscription #{$sub->id} - No phone number found.");
                continue;
            }

            // Logic to send WhatsApp Message
            $message = "Hello {$customerName}, your subscription (ID: {$sub->id}) expires in {$daysLeft} days (" . $sub->end_date->format('Y-m-d') . "). Please renew it.";
            
            // TODO: Integrate WhatsApp API (e.g., Twilio) here.
            // \Twilio::message($phone, $message); 
            
            $this->info("WhatsApp Sent to {$phone}: {$message}");
            \Log::info("WhatsApp Reminder sent to {$phone}: {$message}");

            \App\Models\SubscriptionLog::create([
                'subscription_id' => $sub->id,
                'type' => 'auto',
                'message' => $message,
                'status' => 'sent',
                'sent_at' => now(),
            ]);
        }

        $this->info('All reminders processed.');
    }
}
