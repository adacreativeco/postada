<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use App\Models\Post;
use App\Jobs\ProcessSocialPost;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    $now = now();
    $posts = Post::where('status', 'scheduled')
        ->where('scheduled_at', '<=', $now)
        ->get();

    foreach ($posts as $post) {
        $platforms = $post->platforms; // JSON array assumed
        foreach ($platforms as $platform) {
            ProcessSocialPost::dispatch($post, $platform);
        }
        $post->update(['status' => 'processing']);
    }
})->everyMinute();
