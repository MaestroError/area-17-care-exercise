<x-guest-layout>
    <div class="overflow-x-hidden bg-gray-100 flex-1">
        <div class="px-6 py-8">
            <div class="container flex justify-between mx-auto">
                <div class="w-full lg:w-8/12">
                    <div class="flex items-center justify-between">
                        <h1 class="font-bold text-gray-700 md:text-2xl">
                            <a href="{{route('users.show', ['user' => $post->author])}}" class="flex flex-row items-center hover:underline">
                                <x-heroicon-o-arrow-sm-left style="width: 40px; height: 40px;"/>
                                {{ __('See all posts of ') . ucfirst($post->author->username) }}
                            </a>
                        </h1>
                    </div>

                    @include('front.component.post', ['post' => $post, 'deployBody' => true, 'displayUserProfil' => true, 'needRedirectToPost' => false])

                </div>
                <div class="hidden w-4/12 -mx-8 lg:block">
                    @include('front.component.sidebar.authors')
                    @include('front.component.sidebar.random-post', ['post' => $authors->random()->posts->where('is_active', true)->random()])
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
