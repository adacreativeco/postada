<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SocialManager extends Component
{
    public $isEmbedded = false;

    public function mount($isEmbedded = false)
    {
        $this->isEmbedded = $isEmbedded;
    }

    public function disconnect($accountId)
    {
        $account = Auth::user()->socialAccounts()->findOrFail($accountId);
        $provider = $account->provider;
        $account->delete();

        session()->flash('success', ucfirst($provider) . ' hesabı başarıyla kaldırıldı.');
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    }

    public function render()
    {
        $connectedAccounts = Auth::user()->socialAccounts;

        return view('livewire.social-manager', [
            'connectedAccounts' => $connectedAccounts,
            'availableProviders' => [
                'twitter' => [
                    'name' => 'X (Twitter)',
                    'icon' => 'twitter',
                    'color' => 'bg-black',
                ],
                'linkedin' => [
                    'name' => 'LinkedIn',
                    'icon' => 'linkedin',
                    'color' => 'bg-blue-600',
                ],
                'facebook' => [
                    'name' => 'Facebook',
                    'icon' => 'facebook',
                    'color' => 'bg-blue-700',
                ],
                'instagram' => [
                    'name' => 'Instagram (yakında)',
                    'icon' => 'instagram',
                    'color' => 'bg-gradient-to-tr from-yellow-400 via-red-500 to-purple-600',
                ],
                'tiktok' => [
                    'name' => 'TikTok',
                    'icon' => 'tiktok',
                    'color' => 'bg-black',
                ],
                'reddit' => [
                    'name' => 'Reddit',
                    'icon' => 'reddit',
                    'color' => 'bg-[#FF4500]',
                ],
                'youtube' => [
                    'name' => 'YouTube',
                    'icon' => 'youtube',
                    'color' => 'bg-red-600',
                ],
                'telegram' => [
                    'name' => 'Telegram',
                    'icon' => 'telegram',
                    'color' => 'bg-[#0088cc]',
                ],
                'whatsapp' => [
                    'name' => 'WhatsApp (yakında)',
                    'icon' => 'whatsapp',
                    'color' => 'bg-[#25D366]',
                ],
            ],
        ]);
    }
}
