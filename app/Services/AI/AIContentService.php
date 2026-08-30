<?php

namespace App\Services\AI;

use App\Models\User;
use App\Models\Media;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIContentService
{
    public function generateCaption(User $user, string $prompt): string
    {
        $prefs = $user->ai_preferences ?? [];
        $provider = $prefs['provider'] ?? 'gemini';
        $geminiKey = $prefs['api_keys']['gemini'] ?? config('services.gemini.key', env('GEMINI_API_KEY'));
        $openaiKey = $prefs['api_keys']['openai'] ?? config('services.openai.key', env('OPENAI_API_KEY'));

        if ($provider === 'openai' && $openaiKey) {
            return $this->generateWithOpenAI($openaiKey, $prompt);
        }

        if ($geminiKey) {
            return $this->generateWithGemini($geminiKey, $prompt);
        }

        // Fallback simulated intelligent generator if keys not set
        return "✨ " . ucfirst($prompt) . " ile ilgili en son trendleri ve yenilikleri keşfedin! Daha fazlası için takipte kalın. 🚀 #innovation #trends #growth";
    }

    public function generateHashtags(User $user, string $content): array
    {
        $words = preg_split('/\s+/', trim($content));
        $keywords = array_filter($words, fn($w) => mb_strlen($w) > 4);
        $tags = [];
        foreach (array_slice($keywords, 0, 5) as $w) {
            $clean = preg_replace('/[^\p{L}\p{N}]/u', '', $w);
            if ($clean) {
                $tags[] = '#' . mb_strtolower($clean);
            }
        }
        if (empty($tags)) {
            $tags = ['#postada', '#socialmedia', '#digital', '#trending', '#ai'];
        }
        return array_unique($tags);
    }

    public function changeTone(User $user, string $content, string $tone): string
    {
        $tones = [
            'professional' => "Saygıdeğer takipçilerimiz; " . $content . " Konuyla ilgili detaylı bilgi için profilimizi ziyaret edebilirsiniz.",
            'friendly' => "Selamlar millet! 👋 " . $content . " Siz bu konuda ne düşünüyorsunuz, yorumlarda buluşalım! 😊",
            'creative' => "🎨 İlham dolu bir gün! " . $content . " Hayal gücünüzü sınırlandırmayın. ✨",
            'humorous' => "Bunu buraya bırakıyoruz çünkü kahve henüz bitmedi ☕ " . $content . " 😂",
            'informative' => "📌 Bilgi Notu: " . $content . " Faydalı bulduysanız kaydetmeyi ve paylaşmayı unutmayın!",
        ];

        return $tones[$tone] ?? $content;
    }

    public function generateImage(User $user, string $prompt): string
    {
        // Mock image URL or storage entry
        $placeholderUrl = "https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=800&auto=format&fit=crop&q=60";
        
        Media::create([
            'user_id' => $user->id,
            'filename' => 'ai_generated_' . time() . '.jpg',
            'path' => $placeholderUrl,
            'mime_type' => 'image/jpeg',
            'size' => 204800,
            'disk' => 'public',
        ]);

        return $placeholderUrl;
    }

    protected function generateWithGemini(string $apiKey, string $prompt): string
    {
        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
                    'contents' => [
                        ['parts' => [['text' => "Sen profesyonel bir sosyal medya içerik yöneticisisin. Aşağıdaki konu hakkında dikkat çekici, Türkçe bir sosyal medya gönderisi yaz:\n\n" . $prompt]]]
                    ]
                ]);

            if ($response->successful()) {
                return $response->json('candidates.0.content.parts.0.text') ?? $prompt;
            }
        } catch (\Exception $e) {
            Log::error("Gemini API Error: " . $e->getMessage());
        }

        return "🚀 " . $prompt . " için harika bir içerik hazırlandı!";
    }

    protected function generateWithOpenAI(string $apiKey, string $prompt): string
    {
        try {
            $response = Http::withToken($apiKey)
                ->post("https://api.openai.com/v1/chat/completions", [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        ['role' => 'system', 'content' => 'Sen uzman bir sosyal medya içerik üreticisisin.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ]);

            if ($response->successful()) {
                return $response->json('choices.0.message.content') ?? $prompt;
            }
        } catch (\Exception $e) {
            Log::error("OpenAI API Error: " . $e->getMessage());
        }

        return "🚀 " . $prompt;
    }
}
