<?php

namespace Tests\Back\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UpdatePostTest extends TestCase
{
    use WithFaker,
        RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    /** @test * */
    public function it_should_update_a_post(): void
    {
        $postToUpdate = Post::factory()->create(['author_id' => Auth::id()]);
        $oldBody = $postToUpdate->body;
        $newBody = $this->faker->text;

        $response = $this->put(route('admin.posts.update', [
            'post' => $postToUpdate,
            'title' => $postToUpdate->title,
            'body' => $newBody,
            'is_publishable' => false
        ]));

        $response->assertRedirect(route('admin.dashboard'));

        $postToUpdate->refresh();

        $this->assertNotEquals($oldBody, $newBody);
        $this->assertDatabaseHas('posts', ['body' => $newBody]);
    }
}
