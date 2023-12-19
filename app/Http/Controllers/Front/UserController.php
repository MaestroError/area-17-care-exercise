<?php

namespace App\Http\Controllers\Front;

use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\View\View;

class UserController
{

    /**
     * Display a listing of the user's posts.
     *
     * @param User $user
     * @return View
     */
    public function show(User $user): View
    {
        $authors = User::with('posts')->inRandomOrder()->get()->take(5);
        $posts = Post::displayable()
            ->where('author_id', $user->id)
            ->latest('published_at')
            ->paginate(8);

        return view('front.user.show', compact('user', 'posts', 'authors'));
    }
}
