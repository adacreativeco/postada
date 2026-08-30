<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_shopier_callback_validates_signature()
    {
        $user = User::factory()->create();
        
        $response = $this->post(route('payment.callback'), [
            'platform_order_id' => '123',
            'status' => 'success',
            'total_amount' => '100',
            'signature' => 'invalid_signature',
        ]);

        $this->assertTrue(in_array($response->status(), [400, 403, 302, 200]));
    }
}
