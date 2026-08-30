<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AISettings extends Component
{
    public $provider = 'gemini';
    public $openaiKey = '';
    public $geminiKey = '';

    public function mount()
    {
        $user = Auth::user();
        $prefs = $user->ai_preferences ?? [];

        $this->provider = $prefs['provider'] ?? 'gemini';
        // In a real app, we might want to mask these or not send them back to client for security
        // But for editing purposes, we leave them blank to indicate "unchanged" or let user overwrite
        $this->openaiKey = $prefs['api_keys']['openai'] ?? '';
        $this->geminiKey = $prefs['api_keys']['gemini'] ?? '';
    }

    public function save()
    {
        $user = Auth::user();
        $prefs = $user->ai_preferences ?? [];

        $prefs['provider'] = $this->provider;

        if (!empty($this->openaiKey)) {
            $prefs['api_keys']['openai'] = $this->openaiKey;
        }

        if (!empty($this->geminiKey)) {
            $prefs['api_keys']['gemini'] = $this->geminiKey;
        }

        $user->ai_preferences = $prefs;
        $user->save();

        $this->dispatch('notify', message: 'AI ayarları kaydedildi! ', type: 'success');
    }

    public function render()
    {
        return view('livewire.ai-settings');
    }
}
