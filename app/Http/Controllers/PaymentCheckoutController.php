<?php

namespace App\Http\Controllers;

use App\Models\CreditPackage;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;

class PaymentCheckoutController extends Controller
{
    public function checkout(CreditPackage $package, PaymentService $paymentService)
    {
        try {
            $user = auth()->user();
            $formHtml = $paymentService->initiateTransaction($user, $package);

            return response($formHtml);
        } catch (\Exception $e) {
            return redirect()->route('pricing')->with('error', 'Ödeme başlatılamadı: ' . $e->getMessage());
        }
    }
}
