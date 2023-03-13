<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestRouteTest extends TestCase
{
    /** @test */
    public function it_has_test_routes()
    {
        $this->json('get', '/test')
            ->assertOk()
            ->assertSee('Welcome to testing arena!');
    }
}
