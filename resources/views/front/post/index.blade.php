<x-guest-layout>
    <div class="overflow-x-hidden bg-gray-100 flex-1">
        <div class="px-6 py-8">
            <div class="container flex justify-between mx-auto">
                <div class="w-full lg:w-8/12">
                    <div class="flex items-center justify-between">
                        <h1 class="text-xl font-bold text-gray-700 md:text-2xl">{{ __('All posts') }}</h1>
                    </div>
                    @foreach($posts as $post)
                        @include('front.component.post', ['post' => $post, 'deployBody' => false, 'displayUserProfil' => true, 'needRedirectToPost' => true])
                    @endforeach
                    <div class="mt-8">
                        {{ $posts->links() }}
                    </div>
                </div>
                <div class="hidden w-4/12 -mx-8 lg:block">
                    @include('front.component.sidebar.authors')
                    @include('front.component.sidebar.random-post', ['post' => $posts->where('is_active', true)->random()])
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
