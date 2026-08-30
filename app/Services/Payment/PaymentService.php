<?php

namespace App\Services\Payment;

use App\Models\User;
use App\Models\Package;
use App\Models\PaymentTransaction;
use Illuminate\Support\Str;

class PaymentService
{
    public function initiateTransaction(User $user, Package $package): string
    {
        $orderId = 'ORD-' . strtoupper(Str::random(10));

        PaymentTransaction::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'order_id' => $orderId,
            'amount' => $package->price,
            'currency' => 'TRY',
            'status' => 'pending',
            'credits_added' => $package->credits,
        ]);

        return route('payment.checkout', $package->id);
    }
}
