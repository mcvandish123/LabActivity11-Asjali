<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Post;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostBrowsingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public function test_index_loads_without_lazy_loading_violations(): void
    {
        $this->get(route('posts.index'))
            ->assertOk()
            ->assertSee('Purok Asjali Clean-up Drive')
            ->assertSee('comments');
    }

    public function test_index_hides_drafts(): void
    {
        $draft = Post::where('is_published', false)->firstOrFail();

        $posts = $this->get(route('posts.index', ['q' => $draft->title]))
            ->assertOk()
            ->viewData('posts');

        $this->assertFalse($posts->contains('id', $draft->id));
    }

    public function test_tag_filter_only_returns_posts_with_that_tag(): void
    {
        $response = $this->get(route('posts.index', ['tag' => 'Urgent']))->assertOk();

        $posts = $response->viewData('posts');
        $this->assertGreaterThan(0, $posts->count());

        foreach ($posts as $post) {
            $this->assertTrue($post->tags->contains('name', 'Urgent'));
        }
    }

    public function test_show_page_lists_comments_newest_first_with_commenter_names(): void
    {
        $pinned = Post::where('is_pinned', true)->firstOrFail();

        $response = $this->get(route('posts.show', $pinned->id))
            ->assertOk()
            ->assertSee('Lola Asjali');

        $comments = $response->viewData('post')->comments;
        $this->assertSame(
            $comments->sortByDesc('id')->pluck('id')->all(),
            $comments->pluck('id')->all()
        );
    }

    public function test_author_page_shows_comments_received_through_posts(): void
    {
        $author = Author::where('email', 'kagawad.asjali@bulletin.test')->firstOrFail();
        $count = $author->comments()->count();

        $this->get(route('authors.show', $author))
            ->assertOk()
            ->assertSee($author->name)
            ->assertSee("{$count} ".str($count === 1 ? 'comment' : 'comments')->toString().' received');
    }
}
