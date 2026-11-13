<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostAndCommentFormsTest extends TestCase
{
    use RefreshDatabase;

    private function authorUser(): User
    {
        $user = User::factory()->create();
        Author::factory()->create(['user_id' => $user->id]);

        return $user;
    }

    /**
     * @return array<string, mixed>
     */
    private function validPostData(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Barangay Assembly Notice',
            'body' => 'The barangay assembly will be held this Saturday at the hall.',
            'category' => 'Announcement',
            'tags' => [Tag::create(['name' => 'Urgent'])->id],
            'is_published' => '1',
        ], $overrides);
    }

    public function test_guest_cannot_comment(): void
    {
        $post = Post::factory()->create(['author_id' => Author::factory()->create()->id]);

        $this->post(route('comments.store', $post), ['body' => 'Hello there'])
            ->assertRedirect(route('login'));
    }

    public function test_user_can_comment_through_the_relation(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['author_id' => Author::factory()->create()->id]);

        $this->actingAs($user)
            ->post(route('comments.store', $post), ['body' => 'Salamat po!', 'user_id' => 999])
            ->assertRedirect(route('posts.show', $post->id))
            ->assertSessionHas('status', 'Comment posted.');

        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'body' => 'Salamat po!',
        ]);
    }

    public function test_short_comment_uses_custom_message(): void
    {
        $post = Post::factory()->create(['author_id' => Author::factory()->create()->id]);

        $this->actingAs(User::factory()->create())
            ->post(route('comments.store', $post), ['body' => 'hi'])
            ->assertSessionHasErrors(['body' => 'Purok Asjali comments need at least 3 characters.']);
    }

    public function test_resident_without_author_profile_gets_403(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('posts.store'), $this->validPostData())
            ->assertForbidden();
    }

    public function test_author_creates_published_post_with_tags(): void
    {
        $user = $this->authorUser();
        $data = $this->validPostData();

        $this->actingAs($user)->post(route('posts.store'), $data)->assertRedirect();

        $post = Post::where('title', 'Barangay Assembly Notice')->firstOrFail();
        $this->assertSame($user->author()->value('id'), $post->author_id);
        $this->assertNotNull($post->published_at);
        $this->assertSame($data['tags'], $post->tags()->pluck('tags.id')->all());
    }

    public function test_unchecked_publish_box_saves_a_draft(): void
    {
        $data = $this->validPostData();
        unset($data['is_published']);

        $this->actingAs($this->authorUser())->post(route('posts.store'), $data)
            ->assertRedirect(route('posts.index'));

        $post = Post::where('title', 'Barangay Assembly Notice')->firstOrFail();
        $this->assertFalse($post->is_published);
        $this->assertNull($post->published_at);
    }

    public function test_invalid_post_returns_errors_and_old_input(): void
    {
        $this->actingAs($this->authorUser())
            ->from(route('posts.create'))
            ->post(route('posts.store'), ['title' => 'Only a title', 'category' => 'Nope'])
            ->assertRedirect(route('posts.create'))
            ->assertSessionHasErrors(['body', 'category', 'tags']);
    }

    public function test_create_page_and_new_post_link_depend_on_author_profile(): void
    {
        $this->actingAs($this->authorUser())->get(route('posts.create'))
            ->assertOk()->assertSee('New post');

        $this->actingAs(User::factory()->create())->get(route('posts.index'))
            ->assertDontSee('New post');
    }

    public function test_guest_sees_sign_in_prompt_instead_of_comment_form(): void
    {
        $post = Post::factory()->create(['author_id' => Author::factory()->create()->id]);

        $this->get(route('posts.show', $post->id))->assertSee('Sign in to comment');
    }
}
