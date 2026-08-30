<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\PostMetric;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Analytics extends Component
{
    public $timeRange = '7d';

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    }

    public function render()
    {
        $user = Auth::user();
        $query = $user->posts();

        // Time Range Filtering
        $date = match ($this->timeRange) {
            '24h' => Carbon::now()->subDay(),
            '7d' => Carbon::now()->subDays(7),
            '30d' => Carbon::now()->subDays(30),
            '90d' => Carbon::now()->subDays(90),
            default => Carbon::now()->subDays(7),
        };

        $posts = $query->where('created_at', '>=', $date)->with('metrics')->get();
        $postIds = $posts->pluck('id');

        // 1. KPI Cards
        $totalLikes = PostMetric::whereIn('post_id', $postIds)->where('metric_name', 'likes')->sum('metric_value');
        $totalReach = PostMetric::whereIn('post_id', $postIds)->where('metric_name', 'reach')->sum('metric_value');
        $totalComments = PostMetric::whereIn('post_id', $postIds)->where('metric_name', 'comments')->sum('metric_value');

        // Engagement Rate (Avg per post)
        $avgEngagement = $posts->count() > 0 ? ($totalLikes + $totalComments) / $posts->count() : 0;

        // 2. Engagement Trend (Line Chart & Daily Growth)
        $trendData = PostMetric::whereIn('post_id', $postIds)
            ->where('metric_name', 'likes')
            ->select(DB::raw('DATE(recorded_at) as date'), DB::raw('SUM(metric_value) as total'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $chartLabels = $trendData->pluck('date')->map(fn($d) => Carbon::parse($d)->format('d M'));
        $chartValues = $trendData->pluck('total');

        // 3. Platform Distribution
        $platformData = PostMetric::whereIn('post_id', $postIds)
            ->where('metric_name', 'likes')
            ->select('platform', DB::raw('SUM(metric_value) as total'))
            ->groupBy('platform')
            ->get();

        $platformLabels = $platformData->pluck('platform')->map(fn($p) => ucfirst($p));
        $platformValues = $platformData->pluck('total');

        // 4. Best Time to Post (Heatmap Data)
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        $selectDay = $driver === 'sqlite' ? "strftime('%w', recorded_at)" : "DAYOFWEEK(recorded_at) - 1";
        $selectHour = $driver === 'sqlite' ? "strftime('%H', recorded_at)" : "HOUR(recorded_at)";

        $heatmapData = PostMetric::whereIn('post_id', $postIds)
            ->where('metric_name', 'likes')
            ->select(
                DB::raw("{$selectDay} as day"),
                DB::raw("{$selectHour} as hour"),
                DB::raw('SUM(metric_value) as total')
            )
            ->groupBy('day', 'hour')
            ->get();

        // 5. Top Performing Posts
        $topPosts = $posts->sortByDesc(function ($post) {
            return $post->metrics->where('metric_name', 'likes')->sum('metric_value');
        })->take(5);

        \App\Models\Post::loadMediaFor($topPosts);

        return view('livewire.analytics', [
            'totalLikes' => $totalLikes,
            'totalReach' => $totalReach,
            'totalComments' => $totalComments,
            'avgEngagement' => $avgEngagement,
            'dailyGrowth' => $trendData,
            'platformBreakdown' => $platformData,
            'chartLabels' => $chartLabels,
            'chartValues' => $chartValues,
            'platformLabels' => $platformLabels,
            'platformValues' => $platformValues,
            'heatmapData' => $heatmapData,
            'topPosts' => $topPosts,
        ]);
    }
}
