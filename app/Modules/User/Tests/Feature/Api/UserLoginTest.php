<?php

namespace App\Modules\User\Tests\Feature\Api;

use Tests\TestCase;
use App\Modules\User\Domain\Entities\User;
use Symfony\Component\HttpFoundation\Response;

class UserLoginTest extends TestCase
{
    /**
     * @test
     *
     * @group user
     */
    public function it_can_login()
    {
        $password = $this->faker->password();
        $user = User::factory()->state(['password' => bcrypt($password)])->create();
        $this->assertDatabaseCount('users', 1);
        $res = $this->json('post', route('api.users.login'), [
            'email'    => $user->email,
            'password' => $password,
        ]);

        $res->assertOk();
        $res->assertJsonFragment(['email' => $user->email]);
    }

    /**
     * @test
     *
     * @group user
     */
    public function it_fails_when_provided_with_wrong_credentials(): void
    {
        $password = $this->faker->password();
        $user = User::factory()->state(['password' => bcrypt($password)])->create();
        $res = $this->json('post', route('api.users.login'), [
            'email'    => $user->email,
            'password' => 'secret',
        ]);

        $res->assertStatus(Response::HTTP_UNAUTHORIZED);
        $res->assertJsonFragment(['message' => 'Invalid credentials.']);
    }
}
