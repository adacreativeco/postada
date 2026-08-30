<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/');
    }

    public function deletePost($postId)
    {
        $post = Auth::user()->posts()->find($postId);
        if ($post) {
            $post->delete();
            session()->flash('success', 'İçerik başarıyla silindi.');
        }
    }

    public function render()
    {
        $user = Auth::user();
        $posts = $user->posts()->latest()->take(5)->get();
        \App\Models\Post::loadMediaFor($posts);

        // Simple Analytics for Dashboard
        $postIds = $user->posts()->pluck('id');
        $totalLikes = \App\Models\PostMetric::whereIn('post_id', $postIds)->where('metric_name', 'likes')->sum('metric_value');
        $totalComments = \App\Models\PostMetric::whereIn('post_id', $postIds)->where('metric_name', 'comments')->sum('metric_value');

        $avgEngagement = $postIds->count() > 0 ? (($totalLikes + $totalComments) / $postIds->count()) : 0;

        // Engagement Trend (Last 7 days)
        $trend = \App\Models\PostMetric::whereIn('post_id', $postIds)
            ->where('recorded_at', '>=', now()->subDays(7))
            ->where('metric_name', 'likes')
            ->select(\DB::raw('DATE(recorded_at) as date'), \DB::raw('SUM(metric_value) as total'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->pluck('total')
            ->toArray();

        // Platform Activity
        $platformActivity = \App\Models\PostMetric::whereIn('post_id', $postIds)
            ->where('metric_name', 'likes')
            ->select('platform', \DB::raw('SUM(metric_value) as total'))
            ->groupBy('platform')
            ->get()
            ->mapWithKeys(fn($item) => [$item->platform => $item->total]);

        $maxPlatform = $platformActivity->max() ?: 1;
        $platformPercentages = $platformActivity->map(fn($val) => round(($val / $maxPlatform) * 100));

        return view('livewire.dashboard', [
            'recentPosts' => $posts,
            'avgEngagement' => $avgEngagement,
            'engagementTrend' => $trend,
            'platformPercentages' => $platformPercentages,
        ]);
    }
}
