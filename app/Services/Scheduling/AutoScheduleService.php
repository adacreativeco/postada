<?php

namespace App\Services\Scheduling;

use App\Models\User;
use Carbon\Carbon;

class AutoScheduleService
{
    public function getNextAvailableSlot(User $user): Carbon
    {
        $slots = $user->scheduleSlots()->where('is_active', true)->orderBy('day_of_week')->orderBy('time')->get();

        if ($slots->isEmpty()) {
            // Default: tomorrow at 10:00 AM
            return Carbon::tomorrow()->setTime(10, 0);
        }

        $now = Carbon::now();
        $currentDayOfWeek = $now->dayOfWeek; // 0=Sun, 1=Mon...

        foreach ($slots as $slot) {
            if ($slot->day_of_week == $currentDayOfWeek && Carbon::parse($slot->time)->greaterThan($now)) {
                return Carbon::today()->setTimeFromTimeString($slot->time);
            }
        }

        // Otherwise pick the first slot on next matching day
        $nextSlot = $slots->first();
        $daysUntil = ($nextSlot->day_of_week - $currentDayOfWeek + 7) % 7;
        if ($daysUntil === 0) {
            $daysUntil = 7;
        }

        return Carbon::now()->addDays($daysUntil)->setTimeFromTimeString($nextSlot->time);
    }
}
