<?php

namespace Tests\Back\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class DeletePostTest extends TestCase
{
    use WithFaker,
        RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
    }

    /** @test * */
    public function it_should_delete_a_post(): void
    {
        $post = Post::factory()->create(['author_id' => Auth::id()]);

        $response = $this->delete(route('admin.posts.destroy', ['post' => $post]));
        $response->assertRedirect(route('admin.dashboard'));

        $this->assertDeleted($post);
    }

    /** @test * */
    public function it_should_not_delete_a_post_from_another_user(): void
    {
        $post = Post::factory()->create();

        $response = $this->delete(route('admin.posts.destroy', ['post' => $post]));
        $response->assertForbidden();
    }
}
