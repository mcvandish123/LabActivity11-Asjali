@extends('layouts.app')

@section('content')
    <a href="{{ route('posts.index') }}" class="text-sm text-blue-700 hover:underline">&larr; Back to posts</a>

    <article class="bg-white rounded shadow p-4 sm:p-6 mt-3">
        <div class="flex flex-wrap gap-2 mb-2">
            @if ($post->is_pinned)
                <span class="text-xs bg-yellow-200 text-yellow-900 rounded px-2 py-1">Pinned</span>
            @endif
            <span class="text-xs bg-blue-100 text-blue-800 rounded px-2 py-1">{{ $post->category }}</span>
        </div>

        <h1 class="text-2xl font-bold mb-2">{{ $post->title }}</h1>

        <p class="text-sm text-gray-500 mb-4">
            {{ $post->published_at->format('F j, Y') }} ·
            <a href="{{ route('authors.show', $post->author) }}" class="text-blue-700 hover:underline">{{ $post->author->name }}</a>
            · {{ $post->views }} views
        </p>

        @if ($post->tags->isNotEmpty())
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach ($post->tags as $tag)
                    <a href="{{ route('posts.index', ['tag' => $tag->name]) }}" class="text-xs bg-green-100 text-green-800 rounded px-2 py-1">{{ $tag->name }}</a>
                @endforeach
            </div>
        @endif

        <p class="whitespace-pre-line">{{ $post->body }}</p>
    </article>

    <section class="bg-white rounded shadow p-4 sm:p-6 mt-4">
        <h2 class="text-lg font-semibold mb-3">Comments ({{ $post->comments->count() }})</h2>

        @auth
            @include('partials.error-summary')

            <form method="POST" action="{{ route('comments.store', $post) }}" class="mb-4">
                @csrf
                <label for="body" class="block text-sm font-medium mb-1">Add a comment</label>
                <textarea id="body" name="body" rows="3"
                    class="w-full rounded border border-gray-300 px-3 py-2 @error('body') border-red-500 @enderror">{{ old('body') }}</textarea>
                @error('body')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <button type="submit" class="mt-2 rounded bg-blue-700 px-4 py-2 text-white font-semibold hover:bg-blue-800">Post comment</button>
            </form>
        @endauth
        @guest
            <p class="mb-4 text-sm text-gray-600"><a href="{{ route('login') }}" class="text-blue-700 underline">Sign in to comment</a></p>
        @endguest

        @forelse ($post->comments as $comment)
            <div class="border-t border-gray-200 py-3">
                <p class="text-sm font-semibold">{{ $comment->user->name }}
                    <span class="font-normal text-gray-500">· {{ $comment->created_at->diffForHumans() }}</span>
                </p>
                <p>{{ $comment->body }}</p>
            </div>
        @empty
            <p class="text-sm text-gray-500">No comments yet.</p>
        @endforelse
    </section>
@endsection
