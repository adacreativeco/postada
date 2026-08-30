<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamCollaborationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_switch_teams()
    {
        $user = User::factory()->create();
        $team1 = Team::create(['name' => 'Team Alpha', 'user_id' => $user->id, 'personal_team' => true]);
        $team2 = Team::create(['name' => 'Team Beta', 'user_id' => $user->id, 'personal_team' => false]);
        
        $user->teams()->attach($team1);
        $user->teams()->attach($team2);

        $response = $this->actingAs($user)->post(route('teams.switch', $team2->id));
        $response->assertStatus(302);
        
        $user->refresh();
        $this->assertEquals($team2->id, $user->current_team_id);
    }
}
