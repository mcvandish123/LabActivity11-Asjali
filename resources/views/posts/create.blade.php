@extends('layouts.app')

@section('title', 'New post – Barangay Bulletin')

@section('content')
    <a href="{{ route('posts.index') }}" class="text-sm text-blue-700 hover:underline">&larr; Back to posts</a>

    <div class="bg-white rounded shadow p-4 sm:p-6 mt-3 max-w-2xl">
        <h1 class="text-2xl font-bold mb-4">New post</h1>

        @include('partials.error-summary')

        <form method="POST" action="{{ route('posts.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium mb-1">Title</label>
                <input id="title" type="text" name="title" value="{{ old('title') }}"
                    class="w-full rounded border border-gray-300 px-3 py-2 @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category" class="block text-sm font-medium mb-1">Category</label>
                <select id="category" name="category"
                    class="w-full rounded border border-gray-300 bg-white px-3 py-2 @error('category') border-red-500 @enderror">
                    <option value="">Choose a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>
                    @endforeach
                </select>
                @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="body" class="block text-sm font-medium mb-1">Body</label>
                <textarea id="body" name="body" rows="6"
                    class="w-full rounded border border-gray-300 px-3 py-2 @error('body') border-red-500 @enderror">{{ old('body') }}</textarea>
                @error('body')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <fieldset>
                <legend class="block text-sm font-medium mb-1">Tags</legend>
                <div class="flex flex-wrap gap-4">
                    @foreach ($tags as $tag)
                        <label class="inline-flex items-center gap-2 text-sm">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                @checked(in_array($tag->id, old('tags', [])))>
                            {{ $tag->name }}
                        </label>
                    @endforeach
                </div>
                @error('tags')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('tags.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </fieldset>

            <label class="inline-flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published'))>
                Publish now
            </label>
            @error('is_published')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <div>
                <button type="submit" class="rounded bg-blue-700 px-4 py-2 text-white font-semibold hover:bg-blue-800">Save post</button>
            </div>
        </form>
    </div>
@endsection
