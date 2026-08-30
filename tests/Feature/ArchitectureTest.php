<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Team;
use App\Models\Post;
use App\Models\Media;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArchitectureTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_have_multiple_teams_and_posts()
    {
        $user = User::factory()->create();
        $team = Team::create(['name' => 'Design Team', 'user_id' => $user->id, 'personal_team' => true]);
        $user->current_team_id = $team->id;
        $user->save();

        $post = Post::create([
            'user_id' => $user->id,
            'team_id' => $team->id,
            'content' => 'Hello architecture',
            'platforms' => ['twitter', 'linkedin'],
            'status' => 'draft',
        ]);

        $this->assertEquals(1, $user->posts()->count());
        $this->assertEquals($team->id, $post->team_id);
    }

    public function test_post_load_media_for_method()
    {
        $user = User::factory()->create();
        $media = Media::create([
            'user_id' => $user->id,
            'filename' => 'test.jpg',
            'path' => 'uploads/test.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 1024,
        ]);

        $post = Post::create([
            'user_id' => $user->id,
            'content' => 'Post with media',
            'media_ids' => [$media->id],
            'status' => 'draft',
        ]);

        $posts = collect([$post]);
        Post::loadMediaFor($posts);

        $this->assertCount(1, $post->media);
        $this->assertEquals($media->id, $post->media->first()->id);
    }
}
