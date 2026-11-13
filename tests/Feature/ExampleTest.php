<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * The home page sends visitors to the bulletin.
     */
    public function test_the_home_page_redirects_to_posts(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/posts');
    }
}
