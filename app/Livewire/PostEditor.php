<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

use App\Services\AI\AIContentService;
use Livewire\Attributes\On;

class PostEditor extends Component
{
    public $content = '';
    public $selectedPlatforms = [];
    public $platformOptions = [];
    public $scheduledAt = null;
    public $status = 'draft';
    public $selectedMediaIds = [];
    public $showMediaLibrary = false;

    // AI Properties
    public $showAIAssistant = false;
    public $aiPrompt = '';
    public $aiProvider = 'gemini';

    protected $listeners = [
        'media-selected' => 'addMedia',
    ];

    public function autoSchedule(\App\Services\Scheduling\AutoScheduleService $scheduler)
    {
        try {
            $nextSlot = $scheduler->getNextAvailableSlot(Auth::user());
            $this->scheduledAt = $nextSlot->format('Y-m-d\TH:i');
            $this->dispatch('notify', message: 'Otomatik zamanlandı: ' . $nextSlot->translatedFormat('d F l H:i'), type: 'success');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Hata: ' . $e->getMessage(), type: 'error');
        }
    }

    protected $rules = [
        'content' => 'required|string',
        'selectedPlatforms' => 'required|array|min:1',
        'scheduledAt' => 'nullable|date|after:now',
    ];

    public function generateCaption(AIContentService $aiService)
    {
        $this->validate(['aiPrompt' => 'required|string|min:5']);

        try {
            // Temporary: Set AI provider preference in session or user meta if needed strictly per request 
            // For now, we pass the user which has preferences. 
            // We might need to update user preference before calling service if we want to respect the radio button immediately.
            $user = Auth::user();
            $prefs = $user->ai_preferences ?? [];
            $prefs['provider'] = $this->aiProvider;
            $user->ai_preferences = $prefs;
            $user->save();

            $caption = $aiService->generateCaption($user, $this->aiPrompt);
            $this->content = $caption;
            $this->showAIAssistant = false;
            $this->aiPrompt = '';

            $this->dispatch('notify', message: 'AI içerik oluşturdu! ', type: 'success');

        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Hata: ' . $e->getMessage(), type: 'error');
        }
    }

    public function generateHashtags(AIContentService $aiService)
    {
        if (empty($this->content)) {
            $this->dispatch('notify', message: 'Önce bir içerik yazmalısınız.', type: 'warning');
            return;
        }

        try {
            $user = Auth::user();
            $hashtags = $aiService->generateHashtags($user, $this->content);

            if (!empty($hashtags)) {
                $this->content .= "\n\n" . implode(' ', $hashtags);
                $this->dispatch('notify', message: 'Hashtagler eklendi! #⃣', type: 'success');
            }

        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Hata: ' . $e->getMessage(), type: 'error');
        }
    }

    public function changeTone(string $tone, AIContentService $aiService)
    {
        if (empty($this->content)) {
            $this->dispatch('notify', message: 'Önce bir içerik yazmalısınız.', type: 'warning');
            return;
        }

        try {
            $user = Auth::user();
            $newContent = $aiService->changeTone($user, $this->content, $tone);
            $this->content = $newContent;
            $this->dispatch('notify', message: 'Ton değiştirildi! ', type: 'success');

        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Hata: ' . $e->getMessage(), type: 'error');
        }
    }

    public function addMedia($data)
    {
        if (!in_array($data['id'], $this->selectedMediaIds)) {
            $this->selectedMediaIds[] = $data['id'];
        }
        $this->showMediaLibrary = false;
    }

    public function removeMedia($id)
    {
        $this->selectedMediaIds = array_filter($this->selectedMediaIds, fn($mid) => $mid != $id);
    }

    public function updatedContent()
    {
        // Real-time validation or char count triggers can go here
    }

    public function mount()
    {
        $this->platformOptions = [
            'twitter' => 'feed',
            'linkedin' => 'feed',
            'facebook' => 'feed',
            'instagram' => 'feed',
            'youtube' => 'community',
            'tiktok' => 'feed',
            'reddit' => 'feed',
            'telegram' => 'feed',
            'whatsapp' => 'feed',
        ];
    }

    public function save()
    {
        $this->validate();

        $post = Auth::user()->posts()->create([
            'content' => $this->content,
            'platforms' => $this->selectedPlatforms,
            'status' => $this->scheduledAt ? 'scheduled' : 'draft',
            'scheduled_at' => $this->scheduledAt,
            'media_ids' => $this->selectedMediaIds,
        ]);

        session()->flash('success', 'İçerik başarıyla ' . ($this->scheduledAt ? 'planlandı' : 'kaydedildi') . '.');

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.post-editor', [
            'selectedMedia' => \App\Models\Media::whereIn('id', $this->selectedMediaIds)->get(),
            'platformRules' => [
                'twitter' => ['max' => 280, 'name' => 'X (Twitter)'],
                'linkedin' => ['max' => 3000, 'name' => 'LinkedIn'],
                'facebook' => ['max' => 63206, 'name' => 'Facebook'],
                'instagram' => ['max' => 2200, 'name' => 'Instagram (yakında)'],
                'tiktok' => ['max' => 2200, 'name' => 'TikTok'],
                'reddit' => ['max' => 40000, 'name' => 'Reddit'],
                'youtube' => ['max' => 10000, 'name' => 'YouTube'],
                'telegram' => ['max' => 4096, 'name' => 'Telegram'],
                'whatsapp' => ['max' => 65536, 'name' => 'WhatsApp (yakında)'],
            ]
        ]);
    }
}
