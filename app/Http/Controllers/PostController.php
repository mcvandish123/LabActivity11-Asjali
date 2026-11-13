<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    // Asjali has 6 letters
    private const PER_PAGE = 6;

    public function index(Request $request): View
    {
        $posts = Post::query()
            ->with(['author', 'tags'])
            ->withCount('comments')
            ->where('is_published', true)
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('title', 'like', '%'.$request->input('q').'%');
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category', $request->input('category'));
            })
            ->when($request->filled('tag'), function ($query) use ($request) {
                $query->whereHas('tags', function ($tagQuery) use ($request) {
                    $tagQuery->where('name', $request->input('tag'));
                });
            })
            ->orderByDesc('is_pinned')
            ->latest('published_at')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        $categories = Post::query()->distinct()->orderBy('category')->pluck('category');

        return view('posts.index', compact('posts', 'categories'));
    }

    public function show(int|string $id): View
    {
        // the where() makes drafts return 404 too
        $post = Post::where('is_published', true)->findOrFail($id);

        $post->views = $post->views + 1;
        $post->save();

        $post->load([
            'author',
            'tags',
            'comments' => fn ($query) => $query->latest()->latest('id'),
            'comments.user',
        ]);

        return view('posts.show', compact('post'));
    }
}
