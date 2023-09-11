<?php

namespace Tests\Feature;

use Tests\TestCase;

class PlaygroundRouteTest extends TestCase
{
    /** @test */
    public function it_has_playground_routes()
    {
        $this->json('get', '/playground')
            ->assertOk()
            ->assertSee('Welcome to your playground!');
    }
}
