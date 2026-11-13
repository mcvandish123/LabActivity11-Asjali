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
            {{ $post->published_at->format('F j, Y') }} · Author #{{ $post->author_id }} · {{ $post->views }} views
        </p>

        <p class="whitespace-pre-line">{{ $post->body }}</p>
    </article>
@endsection
