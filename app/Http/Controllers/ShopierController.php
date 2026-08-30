<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Payment\PaymentService;

class ShopierController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function callback(Request $request)
    {
        // Shopier sends a POST request to this URL
        // We need to verify it and update the transaction

        try {
            // Verify signature (handled inside service/driver)
            $this->paymentService->handleCallback($request);

            return redirect()->route('pricing')->with('success', 'Ödeme başarıyla alındı! Kredileriniz hesabınıza yüklendi.');
        } catch (\Exception $e) {
            \Log::error('Shopier Payment Error: ' . $e->getMessage());
            return redirect()->route('pricing')->with('error', 'Ödeme doğrulanamadı. Lütfen destek ekibiyle iletişime geçin.');
        }
    }
}
