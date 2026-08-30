<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AllLivewirePagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $team = Team::create(['name' => 'Main Team', 'user_id' => $user->id, 'personal_team' => true]);
        $user->current_team_id = $team->id;
        $user->save();
        $this->actingAs($user);
    }

    public function test_dashboard_renders_successfully()
    {
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_analytics_renders_successfully()
    {
        $response = $this->get('/analytics');
        $response->assertStatus(200);
    }

    public function test_editor_renders_successfully()
    {
        $response = $this->get('/editor');
        $response->assertStatus(200);
    }

    public function test_calendar_renders_successfully()
    {
        $response = $this->get('/calendar');
        $response->assertStatus(200);
    }

    public function test_accounts_renders_successfully()
    {
        $response = $this->get('/accounts');
        $response->assertStatus(200);
    }

    public function test_team_settings_renders_successfully()
    {
        $response = $this->get('/team/settings');
        $response->assertStatus(200);
    }

    public function test_ai_settings_renders_successfully()
    {
        $response = $this->get('/settings/ai');
        $response->assertStatus(200);
    }

    public function test_account_settings_renders_successfully()
    {
        $response = $this->get('/settings/account');
        $response->assertStatus(200);
    }

    public function test_pricing_renders_successfully()
    {
        $response = $this->get('/pricing');
        $response->assertStatus(200);
    }

    public function test_schedule_settings_renders_successfully()
    {
        $response = $this->get('/settings/schedule');
        $response->assertStatus(200);
    }
}
