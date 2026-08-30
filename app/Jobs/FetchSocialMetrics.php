<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\PostMetric;
use App\Services\SocialAnalyticsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class FetchSocialMetrics implements ShouldQueue
{
    use Queueable;

    public function handle(SocialAnalyticsService $analytics): void
    {
        Log::info("Analitik verileri çekiliyor...");

        // Sadece son 30 günde yayınlanmış postlar için veri çekelim
        $posts = Post::where('status', 'published')
            ->where('published_at', '>=', now()->subDays(30))
            ->get();

        foreach ($posts as $post) {
            // Postun bağlı olduğu sosyal hesabı bulmamız gerekebilir.
            // Şimdilik post->user aracılığıyla hesapları tarayacağız.
            $user = $post->user;

            foreach ($post->platforms as $platform) {
                $account = $user->socialAccounts()->where('provider', $platform)->first();

                if (!$account)
                    continue;

                // Burada post'un o platformdaki ID'sine ihtiyacımız var.
                // İdeal senaryoda Post modelinde 'provider_post_id' gibi bir JSON/Array tutulmalıydı.
                // Şimdilik simüle ediyoruz veya entegrasyon sonrası burası güncellenmeli.
                $providerPostId = 'mock_id_123';

                $metrics = $analytics->fetchPostMetrics($account, $providerPostId);

                foreach ($metrics as $name => $value) {
                    PostMetric::updateOrCreate(
                        [
                            'post_id' => $post->id,
                            'platform' => $platform,
                            'metric_name' => $name,
                        ],
                        [
                            'metric_value' => $value,
                            'recorded_at' => now(),
                        ]
                    );
                }
            }
        }

        Log::info("Analitik veri çekme işlemi tamamlandı.");
    }
}
