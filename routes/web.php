<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Robust Language Switcher Route
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['tr', 'en'])) {
        Session::put('locale', $locale);
        app()->setLocale($locale);
    }
    
    $referer = request()->headers->get('referer');
    if ($referer && !str_contains($referer, '/lang/')) {
        return redirect($referer);
    }
    
    return redirect()->route('dashboard');
})->name('locale.switch');

Route::middleware([
    'auth:web',
])->group(function () {
    Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');
    Route::get('/editor', \App\Livewire\PostEditor::class)->name('editor');
    Route::get('/analytics', \App\Livewire\Analytics::class)->name('analytics');
    Route::get('/calendar', \App\Livewire\Calendar::class)->name('calendar');
    Route::get('/accounts', \App\Livewire\SocialManager::class)->name('social.accounts');
    Route::get('/team/settings', \App\Livewire\TeamSettings::class)->name('team.settings');
    Route::get('/settings/ai', \App\Livewire\AISettings::class)->name('settings.ai');
    Route::get('/settings/account', \App\Livewire\AccountSettings::class)->name('settings.account');
    Route::post('/payment/callback', [App\Http\Controllers\ShopierController::class, 'callback'])->name('payment.callback');
    Route::get('/payment/checkout/{package}', [App\Http\Controllers\PaymentCheckoutController::class, 'checkout'])->name('payment.checkout');
    Route::get('/pricing', App\Livewire\Pricing::class)->name('pricing');
    Route::get('/settings/schedule', \App\Livewire\ScheduleSettings::class)->name('settings.schedule');
    Route::post('/teams/{team}/switch', function (\App\Models\Team $team) {
        if (!auth()->user()->allTeams()->contains('id', $team->id)) {
            abort(403);
        }
        auth()->user()->forceFill(['current_team_id' => $team->id])->save();
        return back();
    })->name('teams.switch');

    // Analytics Report
    Route::get('/analytics/report/download', [\App\Http\Controllers\ReportController::class, 'download'])->name('analytics.report');

    // Social Connections
    Route::get('/auth/{provider}/redirect', [\App\Http\Controllers\SocialController::class, 'redirectToProvider'])->name('social.redirect');
    Route::get('/auth/{provider}/callback', [\App\Http\Controllers\SocialController::class, 'handleProviderCallback'])->name('social.callback');
});
