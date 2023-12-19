
<div class="px-8 mt-10">
    <h1 class="mb-4 text-xl font-bold text-gray-700">{{ __('Random Post') }}</h1>
    <div class="flex flex-col max-w-sm px-8 py-6 mx-auto bg-white rounded-lg shadow-md">
        <div class="mt-4">
            <a href="{{ route('posts.show', ['user' => $post->author, 'post'=>$post]) }}" class="text-lg font-medium text-gray-700 hover:underline">
                {{ $post->title }}
            </a>
        </div>
        <div class="flex items-center justify-between mt-4">
            <div class="flex items-center">
                <img
                    @if(! empty($post->author->profile_photo_path))
                        src="{{ $post->author->profile_photo_url }}"
                    @else
                        src="https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=731&amp;q=80"
                    @endif
                    alt="{{ $post->author->username }}"
                    class="object-cover w-8 h-8 rounded-full">
                <a href="{{route('users.show', ['user' => $post->author])}}" class="mx-3 text-sm text-gray-700 hover:underline">
                    {{ $post->author->username }}
                </a>
            </div>
            <span class="text-sm font-light text-gray-600">
                {{ $post->published_at->format('M d, Y') }}
            </span>
        </div>
    </div>
</div>
