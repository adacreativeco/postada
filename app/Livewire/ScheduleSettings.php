<?php

namespace App\Livewire;

use App\Models\ScheduleSlot;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ScheduleSettings extends Component
{
    public $days = [];
    public $newTime = '';
    public $selectedDay = 1; // Default Monday

    public function mount()
    {
        $this->days = [
            1 => 'Pazartesi',
            2 => 'Salı',
            3 => 'Çarşamba',
            4 => 'Perşembe',
            5 => 'Cuma',
            6 => 'Cumartesi',
            0 => 'Pazar'
        ];
    }

    public function addSlot()
    {
        $this->validate([
            'newTime' => 'required|date_format:H:i',
        ]);

        $user = Auth::user();

        // Check duplicate
        $exists = $user->scheduleSlots()
            ->where('day_of_week', $this->selectedDay)
            ->where('time', $this->newTime . ':00')
            ->exists();

        if ($exists) {
            $this->dispatch('notify', message: 'Bu saat zaten ekli.', type: 'warning');
            return;
        }

        ScheduleSlot::create([
            'user_id' => $user->id,
            'day_of_week' => $this->selectedDay,
            'time' => $this->newTime,
            'is_active' => true
        ]);

        $this->newTime = '';
        $this->dispatch('notify', message: 'Saat eklendi.', type: 'success');
    }

    public function removeSlot($id)
    {
        $slot = ScheduleSlot::find($id);

        if ($slot && $slot->user_id === Auth::id()) {
            $slot->delete();
            $this->dispatch('notify', message: 'Saat silindi.', type: 'success');
        }
    }

    public function render()
    {
        $slots = Auth::user()->scheduleSlots()
            ->orderBy('day_of_week')
            ->orderBy('time')
            ->get()
            ->groupBy('day_of_week');

        return view('livewire.schedule-settings', [
            'slots' => $slots
        ]);
    }
}
