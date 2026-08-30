<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SimulateAnalytics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:simulate-analytics';
    protected $description = 'Gerçekçi analitik verileri simüle eder.';

    public function handle()
    {
        $this->info('Analitik verileri simüle ediliyor...');

        $user = \App\Models\User::first();
        if (!$user) {
            $this->error('Kullanıcı bulunamadı.');
            return;
        }

        // Önce temizleyelim (isteğe bağlı)
        // \App\Models\Post::truncate();
        // \App\Models\PostMetric::truncate();

        $content = [
            'PostPilot ile tanışın! 🚀 #socialmedia #automation',
            'Yeni yıla bomba gibi giriyoruz. Hazır mısınız? 🔥',
            'İstatistikler yanılmaz. 📈 #data #analytics',
            'Türkiye pazarı için Telegram ve WhatsApp destekliyoruz! 🇹🇷',
            'Sadece 5 dakikada tüm platformlara içerik gönderin. ⚡'
        ];

        $platforms = ['twitter', 'linkedin', 'facebook', 'instagram', 'tiktok'];

        for ($i = 0; $i < 10; $i++) {
            $post = \App\Models\Post::create([
                'user_id' => $user->id,
                'content' => $content[array_rand($content)],
                'platforms' => array_intersect($platforms, ['twitter', 'linkedin', 'instagram']),
                'status' => 'published',
                'published_at' => now()->subDays(rand(1, 14)),
            ]);

            // Her post için son 7 günün verilerini üretelim
            for ($d = 0; $d < 7; $d++) {
                $date = now()->subDays($d);
                foreach ($post->platforms as $platform) {
                    $metrics = [
                        'likes' => rand(5, 50) * ($d + 1), // Zamanla artan veri simülasyonu
                        'reach' => rand(100, 1000) * ($d + 1),
                        'comments' => rand(0, 10),
                    ];

                    foreach ($metrics as $name => $value) {
                        \App\Models\PostMetric::create([
                            'post_id' => $post->id,
                            'platform' => $platform,
                            'metric_name' => $name,
                            'metric_value' => $value,
                            'recorded_at' => $date,
                        ]);
                    }
                }
            }
        }

        $this->info('Simülasyon başarıyla tamamlandı. 10 post ve 7 günlük veri oluşturuldu.');
    }
}
