<?php

namespace App\Jobs;

use App\Models\Post;
use App\Services\SocialPublisher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessSocialPost implements ShouldQueue
{
    use Queueable;

    protected $post;
    protected $platform;

    public function __construct(Post $post, $platform)
    {
        $this->post = $post;
        $this->platform = $platform;
    }

    public function handle(SocialPublisher $publisher)
    {
        Log::info("İşleniyor: Post #{$this->post->id} Platform: {$this->platform}");

        $success = $publisher->publish($this->post, $this->platform);

        if ($success) {
            Log::info("Başarılı: Post #{$this->post->id} Platform: {$this->platform}");
        } else {
            throw new \Exception("Yayınlama başarısız oldu.");
        }
    }
}
