<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    /**
     * Redirect to the provider's authentication page.
     */
    public function redirectToProvider($provider)
    {
        try {
            // Check if provider is configured
            $config = config("services.{$provider}");
            if (empty($config['client_id']) && $provider !== 'telegram') {
                return redirect()->route('dashboard')->with('error', ucfirst($provider) . ' yapılandırması eksik. Lütfen .env dosyasını kontrol edin.');
            }

            return Socialite::driver($provider)->redirect();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Sosyal medya yönlendirme hatası ({$provider}): " . $e->getMessage());

            $message = 'Sosyal medya yönlendirmesi sırasında bir hata oluştu.';
            if (str_contains($e->getMessage(), 'Driver') && str_contains($e->getMessage(), 'not supported')) {
                $message = ucfirst($provider) . ' sürücüsü henüz desteklenmiyor.';
            } elseif (str_contains($e->getMessage(), 'client credentials') || str_contains($e->getMessage(), 'client_id')) {
                $message = ucfirst($provider) . ' API anahtarları eksik veya hatalı.';
            }

            return redirect()->route('dashboard')->with('error', $message);
        }
    }

    /**
     * Handle the provider's callback.
     */
    public function handleProviderCallback($provider)
    {
        try {
            /** @var \Laravel\Socialite\Two\User $socialUser */
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Sosyal medya girişi iptal edildi veya bir hata oluştu.');
        }

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Lütfen önce giriş yapın.');
        }

        // Link the social account to the user
        $user->socialAccounts()->updateOrCreate(
            [
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
            ],
            [
                'token' => $socialUser->token,
                'refresh_token' => $socialUser->refreshToken ?? null,
                'expires_at' => property_exists($socialUser, 'expiresIn') ? now()->addSeconds($socialUser->expiresIn) : (isset($socialUser->expiresIn) ? now()->addSeconds($socialUser->expiresIn) : null),
                'nickname' => $socialUser->getNickname(),
                'avatar' => $socialUser->getAvatar(),
            ]
        );

        return redirect()->route('dashboard')->with('success', ucfirst($provider) . ' hesabı başarıyla bağlandı!');
    }
}
