<?php

namespace App\Livewire;

use Livewire\Component;

class TeamManager extends Component
{
    public $team;
    public $email;
    public $role = 'editor';

    public function mount($team)
    {
        $this->team = $team;
    }

    public function addMember()
    {
        $this->validate([
            'email' => 'required|email|max:255',
            'role' => 'required|string|in:admin,editor,viewer',
        ]);

        // Check if user already in team
        $user = \App\Models\User::where('email', $this->email)->first();
        if ($user && $this->team->users->contains($user->id)) {
            $this->addError('email', 'Bu kullanıcı zaten ekipte.');
            return;
        }

        // Create Invitation
        $this->team->invitations()->create([
            'email' => $this->email,
            'role' => $this->role,
        ]);

        $this->reset('email');
        session()->flash('success', 'Davet gönderildi.');
    }

    public function removeMember($userId)
    {
        // Owner cannot be removed
        if ($userId === $this->team->user_id) {
            session()->flash('error', 'Ekip sahibini çıkaramazsınız.');
            return;
        }

        $this->team->users()->detach($userId);
        session()->flash('success', 'Üye ekipten çıkarıldı.');
    }

    public function deleteInvitation($invitationId)
    {
        $this->team->invitations()->where('id', $invitationId)->delete();
        session()->flash('success', 'Davet iptal edildi.');
    }

    public function render()
    {
        return view('livewire.team-manager', [
            'members' => $this->team->users()->withPivot('role')->get(),
            'invitations' => $this->team->invitations,
        ]);
    }
}
