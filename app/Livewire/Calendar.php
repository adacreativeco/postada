<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Calendar extends Component
{
    public $month;
    public $year;
    public $daysInMonth;
    public $blankDays;
    public $currentMonthName;

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    }

    public function mount()
    {
        $this->month = now()->month;
        $this->year = now()->year;
        $this->calculateCalendar();
    }

    public function calculateCalendar()
    {
        $date = Carbon::create($this->year, $this->month, 1);
        $this->daysInMonth = $date->daysInMonth;
        $this->blankDays = $date->dayOfWeek; // 0 (Sun) to 6 (Sat)
        $this->currentMonthName = $date->translatedFormat('F Y');
    }

    public function nextMonth()
    {
        $date = Carbon::create($this->year, $this->month, 1)->addMonth();
        $this->month = $date->month;
        $this->year = $date->year;
        $this->calculateCalendar();
    }

    public function prevMonth()
    {
        $date = Carbon::create($this->year, $this->month, 1)->subMonth();
        $this->month = $date->month;
        $this->year = $date->year;
        $this->calculateCalendar();
    }

    public function reschedule($postId, $newDay)
    {
        $post = Auth::user()->posts()->find($postId);

        if (!$post || $post->status === 'published') {
            return;
        }

        $newDate = Carbon::create(
            $this->year,
            $this->month,
            $newDay,
            $post->scheduled_at->hour,
            $post->scheduled_at->minute
        );

        $post->update([
            'scheduled_at' => $newDate
        ]);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Gönderi ' . $newDay . ' ' . $this->currentMonthName . ' tarihine taşındı.'
        ]);
    }

    public function render()
    {
        $posts = Auth::user()->posts()
            ->whereYear('scheduled_at', $this->year)
            ->whereMonth('scheduled_at', $this->month)
            ->orWhere(function ($query) {
                $query->whereYear('published_at', $this->year)
                    ->whereMonth('published_at', $this->month);
            })
            ->get();

        \App\Models\Post::loadMediaFor($posts);

        $groupedPosts = $posts->groupBy(function ($post) {
            $date = $post->scheduled_at ?? $post->published_at;
            return $date->day;
        });

        return view('livewire.calendar', [
            'postsByDay' => $groupedPosts
        ]);
    }
}
