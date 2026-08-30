<?php

namespace App\Jobs;

use App\Models\SocialAccount;
use App\Models\AccountMetric;
use App\Services\SocialAnalyticsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class FetchAccountStats implements ShouldQueue
{
    use Queueable;

    public function handle(SocialAnalyticsService $analyticsService): void
    {
        Log::info("Hesap istatistikleri çekiliyor...");

        $accounts = SocialAccount::whereNotNull('token')->get();

        foreach ($accounts as $account) {
            /** @var SocialAccount $account */
            try {
                $stats = $analyticsService->fetchAccountStats($account);

                AccountMetric::create([
                    'social_account_id' => $account->id,
                    'follower_count' => $stats['follower_count'],
                    'following_count' => $stats['following_count'],
                    'engagement_rate' => $stats['engagement_rate'],
                    'recorded_at' => now(),
                ]);
            } catch (\Exception $e) {
                Log::error("Hesap ID {$account->id} istatistik hatası: " . $e->getMessage());
            }
        }

        Log::info("Hesap istatistikleri tamamlandı.");
    }
}
