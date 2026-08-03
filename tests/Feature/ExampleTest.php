<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * The root URL has no locale prefix and redirects permanently to /nl,
     * the canonical Dutch homepage. See routes/web.php.
     */
    public function test_the_root_url_redirects_to_the_dutch_homepage(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/nl');
    }
}
