<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit ') . $post->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <x-jet-validation-errors/>

            <form action="{{ route('admin.posts.update', $post) }}" method="post" class="mt-5">
                @method('put')
                @csrf

                <div class="flex flex-col mb-4">
                    <x-jet-label class="mb-2 font-bold text-lg text-gray-900" for="title">{{ __('Title of the post') }}</x-jet-label>
                    <x-jet-input class="py-2 px-3 " name="title" id="title" value="{{ $post->title }}" autofocus/>
                </div>

                <div class="flex flex-col mb-4">
                    <x-jet-label class="mb-2 font-bold text-lg text-gray-900" for="body">{{ __('Content of the post') }}</x-jet-label>
                    <textarea rows="10" name="body" id="body" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" maxlength="1450"> {{ $post->body }}</textarea>
                </div>

                <div class="flex flex-col mb-4">

                    <x-jet-label class="mb-2 font-bold text-lg text-gray-900" for="is_publishable">
                        {{ __('Do you want to publish it ?') }}
                    </x-jet-label>

                    <input type="hidden" name="is_publishable" value="0"/>

                    <input
                        type="checkbox"
                        name="is_publishable"
                        id="is_publishable"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        value="1"
                        @if($post->isPublic()) checked="checked" @endif
                    />
                </div>

                <x-jet-button class="mt-10">{{ __('Edit my post') }}</x-jet-button>
            </form>
        </div>
    </div>
</x-app-layout>
