<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\View\View;

class AuthorController extends Controller
{
    public function show(Author $author): View
    {
        $posts = $author->posts()
            ->with('tags')
            ->withCount('comments')
            ->where('is_published', true)
            ->orderByDesc('is_pinned')
            ->latest('published_at')
            ->get();

        $commentsReceived = $author->comments()->count();

        $recentComments = $author->comments()
            ->with(['post', 'user'])
            ->latest('comments.created_at')
            ->latest('comments.id')
            ->limit(5)
            ->get();

        $author->load('user');

        return view('authors.show', compact('author', 'posts', 'commentsReceived', 'recentComments'));
    }
}
