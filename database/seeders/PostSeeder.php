<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = Author::all();

        Post::factory()->count(40)
            ->sequence(fn ($seq) => ['author_id' => $authors->random()->id])
            ->create();

        Post::factory()->count(10)->draft()
            ->sequence(fn ($seq) => ['author_id' => $authors->random()->id])
            ->create();

        $kagawad = Author::where('email', 'kagawad.asjali@bulletin.test')->firstOrFail();

        Post::create([
            'author_id' => $kagawad->id,
            'title' => 'Purok Asjali Clean-up Drive',
            'category' => 'Announcement',
            'body' => "All households of Purok Asjali are invited to join the clean-up drive on Saturday, May 23, 2026.\n\nWe will meet at the Barangay Matina Crossing Hall at 6:00 in the morning. Please bring your own gloves, walis and sako.\n\nGarbage will be collected along the main road after the activity.",
            'is_published' => true,
            'is_pinned' => true,
            'published_at' => '2026-05-23 06:00:00',
        ]);
    }
}
