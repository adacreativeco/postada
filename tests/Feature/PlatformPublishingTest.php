<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\SocialPublisher;
use App\Models\SocialAccount;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlatformPublishingTest extends TestCase
{
    use RefreshDatabase;

    public function test_social_publisher_dispatches_content()
    {
        $user = User::factory()->create();
        $account = SocialAccount::create([
            'user_id' => $user->id,
            'provider' => 'twitter',
            'provider_id' => '123456',
            'token' => 'fake_token',
        ]);

        $post = Post::create([
            'user_id' => $user->id,
            'content' => 'Automated test tweet',
            'platforms' => ['twitter'],
            'status' => 'draft',
        ]);

        $this->actingAs($user);
        $publisher = new SocialPublisher();
        $res = $publisher->publish($post, 'twitter');
        $this->assertTrue($res);
    }
}
