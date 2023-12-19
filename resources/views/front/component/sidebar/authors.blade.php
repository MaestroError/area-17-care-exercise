<div class="px-8">
    <h1 class="mb-4 text-xl font-bold text-gray-700">{{__('Random authors')}}</h1>
    <div class="flex flex-col max-w-sm px-6 py-4 mx-auto bg-white rounded-lg shadow-md">
        <ul class="-mx-4">
            @foreach($authors as $author)
                <li class="flex items-center my-3">
                    <img
                        @if(! empty($author->profile_photo_path))
                            src="{{ $author->profile_photo_url }}"
                        @else
                            src="https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=731&amp;q=80"
                        @endif
                        alt="{{ $author->username }}"
                        class="object-cover w-10 h-10 mx-4 rounded-full">
                    <p>
                        <a href="{{ route('users.show', $author) }}" class="mx-1 font-bold text-gray-700 hover:underline">
                            {{ $author->username }}
                        </a>
                        <span class="text-sm font-light text-gray-700">
                            {{ __('Created ') . $author->posts_count . __(' Posts') }}
                        </span>
                    </p>
                </li>
            @endforeach
        </ul>
    </div>
</div>
