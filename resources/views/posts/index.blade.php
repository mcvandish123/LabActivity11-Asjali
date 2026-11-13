@extends('layouts.app')

@section('content')
    <form method="GET" action="{{ route('posts.index') }}" class="flex flex-col sm:flex-row gap-2 mb-6">
        <input name="q" value="{{ request('q') }}" placeholder="Search title" class="flex-1 border border-gray-300 rounded px-3 py-2">

        <select name="category" class="border border-gray-300 rounded px-3 py-2 bg-white">
            <option value="">All categories</option>
            @foreach ($categories as $c)
                <option value="{{ $c }}" @selected(request('category') === $c)>{{ $c }}</option>
            @endforeach
        </select>

        <button class="bg-blue-700 text-white rounded px-4 py-2">Filter</button>
    </form>

    <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3">
        @forelse ($posts as $post)
            <div class="bg-white rounded shadow p-4">
                <div class="flex flex-wrap gap-2 mb-2">
                    @if ($post->is_pinned)
                        <span class="text-xs bg-yellow-200 text-yellow-900 rounded px-2 py-1">Pinned</span>
                    @endif
                    <span class="text-xs bg-blue-100 text-blue-800 rounded px-2 py-1">{{ $post->category }}</span>
                </div>

                <h2 class="font-semibold mb-2">
                    <a href="{{ route('posts.show', $post->id) }}" class="hover:underline">{{ $post->title }}</a>
                </h2>

                <p class="text-sm text-gray-500">{{ $post->published_at->format('M j, Y') }}</p>
                <p class="text-sm text-gray-500">Author #{{ $post->author_id }} · {{ $post->views }} views</p>
            </div>
        @empty
            <p class="sm:col-span-2 md:col-span-3">No posts match your search.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>

    @if ($posts->total() > 0)
        <p class="mt-2 text-sm text-gray-600">Showing {{ $posts->firstItem() }}–{{ $posts->lastItem() }} of {{ $posts->total() }} posts</p>
    @endif
@endsection
