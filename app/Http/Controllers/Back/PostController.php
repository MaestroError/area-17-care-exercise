<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Post::class);
        return view('admin.post.create');
    }

    /**
     * Store a newly created post in database.
     *
     * @param StorePostRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $this->authorize('create', Post::class);
        $validated = $request->validated();

        if ($validated['is_publishable']) {
            $validated += [
                'is_active' => true,
                'published_at' => Carbon::now(),
                'author_id' => Auth::id()
            ];
        } else {
            $validated += ['author_id' => Auth::id()];
        }

        Post::create($validated);

        return redirect()->route('admin.dashboard')->with('success', __('Post created successfully!'));
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Post $post): View
    {
        return view('admin.post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePostRequest $request
     * @param Post $post
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        try {
            $this->authorize('update', $post);
        } catch (AuthorizationException $e) {
            // Redirect back with a custom error message
            return back()->withErrors(['authorization' => 'You are not authorized to edit this post.']);
        }
        
        $validated = $request->validated();

        if ($post->is_active === false && $validated['is_publishable']) {
            $validated += [
                'is_active' => true,
                'published_at' => Carbon::now(),
            ];
        } elseif ($post->is_active === true && ! $validated['is_publishable']) {
            $validated += [
                'is_active' => false,
                'published_at' => null
            ];
        }

        $post->update($validated);

        return redirect()->route('admin.dashboard')->with('success', __('Post successfully updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('admin.dashboard')->with('success', __('Post successfully deleted!'));
    }
}
