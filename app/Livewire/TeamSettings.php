<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

class TeamSettings extends Component
{
    public $team;
    public $name;

    public function mount()
    {
        $this->team = auth()->user()->currentTeam();
        $this->name = $this->team->name;
    }

    public function updateTeamName()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->team->update(['name' => $this->name]);

        session()->flash('success', 'Ekip adı başarıyla güncellendi.');
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.team-settings');
    }
}
