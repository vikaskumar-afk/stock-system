<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Subscription;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;    
use App\Mail\CustomerWelcomeMail;

class CustomerService
{
    public function createCustomer(array $validated)
    {
        $subscription = Subscription::findOrFail($validated['subscription_id']);

        // ✅ Auto-generate password
        $plainPassword = Str::random(10);

        // ✅ Save plain password in log (same as before)
        // Log::info('New Customer Password Generated', [
        //     'email' => $validated['email'],
        //     'plain_password' => $plainPassword
        // ]);
        // php artisan optimize:clear

        // ✅ Create customer (same logic)
        Customer::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($plainPassword),
            'subscription_id' => $validated['subscription_id'],
            'remaining_recommendations' => $subscription->recommendation_limit,
        ]);

        // ✅ Send welcome email
        Mail::to($validated['email'])->send(new CustomerWelcomeMail($validated['name'], $validated['email'], $plainPassword));
    }
}