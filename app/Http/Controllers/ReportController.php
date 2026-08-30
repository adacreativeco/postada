<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostMetric;
use App\Models\AccountMetric;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function download(Request $request)
    {
        $user = auth()->user();
        $team = $user->currentTeam(); // Assuming team context

        // 1. Fetch Post Metrics Aggregates
        // We'll aggregate by platform for the report
        $postMetrics = PostMetric::whereHas('post', function ($query) use ($team) {
            $query->where('team_id', $team->id);
        })
            ->selectRaw('platform, metric_name, SUM(metric_value) as total_value')
            ->groupBy('platform', 'metric_name')
            ->get();

        // 2. Fetch Account Growth
        $accountMetrics = AccountMetric::whereHas('socialAccount', function ($query) use ($team) {
            $query->where('team_id', $team->id);
        })
            ->orderBy('recorded_at', 'desc')
            ->take(30) // Last 30 records
            ->get();

        $data = [
            'teamName' => $team->name,
            'date' => now()->format('Y-m-d'),
            'postMetrics' => $postMetrics,
            'accountMetrics' => $accountMetrics,
        ];

        $pdf = Pdf::loadView('pdf.analytics-report', $data);

        return $pdf->download('postpilot-report-' . now()->format('Ymd') . '.pdf');
    }
}
