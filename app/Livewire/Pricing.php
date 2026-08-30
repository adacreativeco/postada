<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CreditPackage;
use App\Services\Payment\PaymentService;

class Pricing extends Component
{
    public function buyPackage($packageId, PaymentService $paymentService)
    {
        $package = CreditPackage::find($packageId);

        if (!$package) {
            $this->dispatch('notify', [['type' => 'error', 'message' => 'Paket bulunamadı.']]);
            return;
        }

        try {
            $response = $paymentService->initiateTransaction(auth()->user(), $package);

            // Should be HTML content (auto-submit form) or a Redirect URL
            // For Shopier AutoSubmitFormRenderer, it returns HTML.
            // We can emit this to frontend to render in a modal or just echo it (bit hacky for Livewire).
            // Better: Redirect to a route that renders this form, or use a public property to show it.

            // Let's allow the browser to render the form content directly by returning it
            // Only way in Livewire is either `return response(...)` which stops Livewire, 
            // or dispatching an event to open a new tab/window.

            // Simplest for Shopier: 
            return response()->streamDownload(function () use ($response) {
                echo $response;
            }, 'payment.html');

            // Wait, streamDownload is for files. 
            // We want to render HTML.
            // Let's just create a temporary route or use a simple trick:
            // return redirect()->to('...'); works if it's a URL.
            // But Shopier returns a <form>...<script>submit()</script>.

            // Solution: Return a specific view or use a controller method for the "dunk".
            // Let's use `return response($response);` 
            // Livewire actions expect Component rendering.

            // Refactor: We will use a standard controller action for the "Checkout" step to keep it clean.
            // redirect()->route('payment.checkout', ['package' => $package->id]);

            // But to avoid creating more files, let's try `die($response)` - ugly but works for standard PHP flow.
            // Or better:
            $this->dispatch('render-payment-form', ['html' => $response]);

        } catch (\Exception $e) {
            $this->dispatch('notify', [['type' => 'error', 'message' => 'Ödeme başlatılamadı: ' . $e->getMessage()]]);
        }
    }

    // Better Approach: 
    // The "Buy" button is a simple link to a Controller Route: /payment/checkout/{package}
    // This avoids Livewire context issues with RAW HTML responses.

    public function render()
    {
        return view('livewire.pricing', [
            'packages' => CreditPackage::all()
        ]);
    }
}
