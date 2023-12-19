<div class="mt-6">
    <div class="max-w-4xl px-10 py-6 mx-auto bg-white rounded-lg shadow-md">
        @if($needRedirectToPost)
            <div class="flex items-center">
                <span class="font-light text-gray-600 mb-2">
                    {{ $post->published_at->format('d M Y') }}
                </span>
            </div>
            <a href="{{ route('posts.show', ['user' => $post->author, 'post'=> $post]) }}" class="text-2xl font-bold text-gray-700 hover:underline mb-4">
                {{ $post->title }}
            </a>
        @else
            <p class="text-2xl font-bold text-gray-700 mb-4">
                {{ $post->title }}
            </p>
        @endif

        <p class="leading-relaxed mt-2 text-gray-600 mb-6">
            @if(! $deployBody)
                {!! \Illuminate\Support\Str::limit($post->body)  !!}
            @else
                {!! $post->body !!}
            @endif
        </p>
        <hr>
        <div class="flex items-center justify-between mt-4">
            @if($needRedirectToPost)
                <a href="{{ route('posts.show', ['user' => $post->author, 'post'=>$post]) }}"
                   class="px-2 py-1 font-bold text-gray-100 bg-gray-600 rounded hover:bg-gray-500">
                    {{ __('Read more') }}
                </a>
            @else
                <span class="font-bold text-gray-600 mb-2">
                    {{ __('Written the, ') . $post->published_at->format('d M Y') }}
                </span>
            @endif
            @if($displayUserProfil)
                <a href="{{route('users.show', ['user' => $post->author])}}" class="flex items-center">
                    <img
                        @if(! empty($post->author->profile_photo_path))
                            src="{{ $post->author->profile_photo_url }}"
                        @else
                            src="https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=731&amp;q=80"
                        @endif
                        alt="{{ $post->author->username }}"
                        class="hidden object-cover w-10 h-10 mx-4 rounded-full sm:block">

                    <h1 class="font-bold text-gray-700 hover:underline">
                        {{ $post->author->username }}
                    </h1>
                </a>
            @endif
        </div>
    </div>
</div>
