<?php

namespace Tests\Back\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CheckPostViewsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    /**
     * @test
     */
    public function it_should_return_the_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function it_should_return_the_edit_view(): void
    {
        $post = Post::factory()->create(['author_id' => Auth::id()]);
        $response = $this->get(route('admin.posts.edit', $post));
        $response->assertStatus(200);
    }
}
