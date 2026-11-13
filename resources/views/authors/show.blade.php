@extends('layouts.app')

@section('title', $author->name.' – Barangay Bulletin')

@section('content')
    <a href="{{ route('posts.index') }}" class="text-sm text-blue-700 hover:underline">&larr; Back to posts</a>

    <div class="bg-white rounded shadow p-4 sm:p-6 mt-3 mb-6">
        <h1 class="text-2xl font-bold">{{ $author->name }}</h1>
        <p class="text-gray-600">{{ $author->position }}</p>
        <p class="mt-2 text-sm text-gray-500">{{ $commentsReceived }} {{ Str::plural('comment', $commentsReceived) }} received</p>
    </div>

    <h2 class="text-lg font-semibold mb-3">Published posts</h2>

    <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3">
        @forelse ($posts as $post)
            <div class="bg-white rounded shadow p-4">
                <div class="flex flex-wrap gap-2 mb-2">
                    @if ($post->is_pinned)
                        <span class="text-xs bg-yellow-200 text-yellow-900 rounded px-2 py-1">Pinned</span>
                    @endif
                    <span class="text-xs bg-blue-100 text-blue-800 rounded px-2 py-1">{{ $post->category }}</span>
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('posts.index', ['tag' => $tag->name]) }}" class="text-xs bg-green-100 text-green-800 rounded px-2 py-1">{{ $tag->name }}</a>
                    @endforeach
                </div>

                <h3 class="font-semibold mb-2">
                    <a href="{{ route('posts.show', $post->id) }}" class="hover:underline">{{ $post->title }}</a>
                </h3>

                <p class="text-sm text-gray-500">{{ $post->published_at->format('M j, Y') }}</p>
                <p class="text-sm text-gray-500">{{ $post->comments_count }} comments · {{ $post->views }} views</p>
            </div>
        @empty
            <p class="sm:col-span-2 md:col-span-3">No published posts yet.</p>
        @endforelse
    </div>
@endsection
