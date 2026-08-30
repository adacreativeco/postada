<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'current_team_id',
        'ai_credits',
        'ai_preferences',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'ai_credits' => 'integer',
            'ai_preferences' => 'array',
        ];
    }

    public function socialAccounts(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    public function scheduleSlots(): HasMany
    {
        return $this->hasMany(ScheduleSlot::class);
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_user')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function ownedTeams(): HasMany
    {
        return $this->hasMany(Team::class, 'user_id');
    }

    public function allTeams()
    {
        return $this->ownedTeams->merge($this->teams);
    }

    public function currentTeam(): ?Team
    {
        if ($this->current_team_id) {
            $team = Team::find($this->current_team_id);
            if ($team) {
                return $team;
            }
        }

        $team = $this->ownedTeams()->first() ?? $this->teams()->first();
        if ($team) {
            $this->forceFill(['current_team_id' => $team->id])->save();
            return $team;
        }

        $newTeam = Team::create([
            'name' => ($this->name ?? 'User') . "'s Team",
            'user_id' => $this->id,
            'personal_team' => true,
        ]);
        $this->forceFill(['current_team_id' => $newTeam->id])->save();
        return $newTeam;
    }
}
