<?php

namespace App\Modules\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetUserSubscriptionTest extends TestCase
{
    /** @test */
    public function example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
