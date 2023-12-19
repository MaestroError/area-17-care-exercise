<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create a new post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-jet-validation-errors/>

            <form action="{{ route('admin.posts.store') }}" method="post" class="mt-5">
                @csrf

                <div class="flex flex-col mb-4">
                    <x-jet-label class="mb-2 font-bold text-lg text-gray-900" for="title">{{ __('Title of the post') }}</x-jet-label>
                    <x-jet-input class="py-2 px-3 " name="title" id="title" value="{{ old('title') }}" autofocus/>
                </div>

                <div class="flex flex-col mb-4">
                    <x-jet-label class="mb-2 font-bold text-lg text-gray-900" for="body">{{ __('Content of the post') }}</x-jet-label>
                    <textarea rows="10" name="body" id="body" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"> {{ old('body') }}</textarea>
                </div>

                <div class="flex flex-col mb-4">
                    <x-jet-label class="mb-2 font-bold text-lg text-gray-900" for="is_publishable">
                        {{ __('Do you want to publish it ?') }}
                    </x-jet-label>
                    <input type="hidden" name="is_publishable" value="0"/>
                    <x-jet-checkbox
                        type="checkbox"
                        name="is_publishable"
                        id="is_publishable"
                        value="1"/>
                </div>

                <x-jet-button style="display: block !important" class="mt-10">{{ __('Create my post') }}</x-jet-button>
            </form>
        </div>
    </div>
</x-app-layout>
