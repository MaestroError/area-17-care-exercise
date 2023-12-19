<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $authors = User::with('posts')->inRandomOrder()->get()->take(5);

        $posts = Post::displayable()
        ->latest('published_at')
        ->paginate(8);

        return view('front.post.index', compact('posts', 'authors'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @param Post $post
     * @return View
     */
    public function show(User $user, Post $post): View
    {
        $authors = User::with('posts')->inRandomOrder()->limit(5)->get();

        return view('front.post.show', compact('post', 'authors'));
    }
}
