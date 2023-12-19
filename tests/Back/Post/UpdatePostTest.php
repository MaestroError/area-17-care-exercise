<?php

namespace Tests\Back\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

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

    public function test_user_cannot_edit_other_users_post()
    {
        // Create two users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Create a post belonging to user2
        $post = Post::factory()->create(['author_id' => $user2->id]);

        // Act as user1
        $this->actingAs($user1);

        // Attempt to update user2's post
        $response = $this->put(route('admin.posts.update', $post->slug), [
            'title' => 'Updated Title',
            'body' => 'Updated body text',
            'is_publishable' => true,
        ]);

        // Assert the user is redirected back
        $response->assertRedirect();

        // Assert session has specific error
        $response->assertSessionHasErrors(['authorization']);

        // Optionally: check that the post title and body haven't changed
        $post->refresh();
        $this->assertNotEquals('Updated Title', $post->title);
        $this->assertNotEquals('Updated body text', $post->body);
    }
}
