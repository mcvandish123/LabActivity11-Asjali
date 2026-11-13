<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['Purok Asjali', 'Urgent', 'Health', 'Livelihood', 'Event'] as $name) {
            Tag::create(['name' => $name]);
        }

        $tagIds = Tag::pluck('id');

        Post::where('is_pinned', false)->get()->each(function (Post $post) use ($tagIds) {
            $post->tags()->attach($tagIds->random(random_int(1, 3)));
        });

        $pinnedTagIds = Tag::whereIn('name', ['Purok Asjali', 'Urgent'])->pluck('id');

        Post::where('is_pinned', true)->get()->each(function (Post $post) use ($pinnedTagIds) {
            $post->tags()->sync($pinnedTagIds);
        });
    }
}
