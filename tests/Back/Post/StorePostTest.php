<?php

namespace Tests\Back\Post;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class StorePostTest extends TestCase
{
    use WithFaker,
        RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }


    /** @test * */
    public function it_should_store_a_post(): void
    {
        $title = $this->faker->title;

        $response = $this->post(route('admin.posts.store', [
            'title' => $title,
            'body' => $this->faker->text,
            'is_publishable' => true
        ]));

        $response->assertRedirect(route('admin.dashboard'));

        $post = Post::displayable()->where('title', $title)->first();

        $this->assertEquals(Str::slug($title), $post->slug);
        $this->assertDatabaseHas('posts', ['title' => $post?->title]);
    }
}
// Ajouter un screen du blog front/back, dans le README
// Ajouter le process d'install dans le README
