<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::pluck('id');
        $lolaId = User::where('email', 'lola.asjali@bulletin.test')->value('id');

        Post::where('is_published', true)->where('is_pinned', false)->get()
            ->each(function (Post $post) use ($userIds) {
                Comment::factory()
                    ->count(random_int(0, 5))
                    ->sequence(fn () => ['user_id' => $userIds->random()])
                    ->create(['post_id' => $post->id]);
            });

        $pinned = Post::where('is_pinned', true)->firstOrFail();

        Comment::factory()->create([
            'post_id' => $pinned->id,
            'user_id' => $lolaId,
            'body' => 'Maayo kaayo ni! Mutambong ko, dad-on nako ang akong walis.',
        ]);

        Comment::factory()
            ->count(3)
            ->sequence(fn () => ['user_id' => $userIds->random()])
            ->create(['post_id' => $pinned->id]);
    }
}
