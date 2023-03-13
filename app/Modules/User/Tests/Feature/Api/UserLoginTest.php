<?php

namespace App\Modules\User\Tests\Feature\Api;

use Tests\TestCase;
use App\Modules\User\Domain\Entities\User;
use Symfony\Component\HttpFoundation\Response;

class UserLoginTest extends TestCase
{
    /** @test */
    public function it_can_login()
    {
        $password = $this->faker->password();
        $user     = User::factory()->state(['password' => bcrypt($password)])->create();
        $this->assertDatabaseCount('users', 1);
        $res = $this->json('post', '/api/login', [
            'email'    => $user->email,
            'password' => $password,
        ]);

        $res->assertOk();
        $res->assertJsonFragment(['email' => $user->email]);
    }

    /** @test */
    public function it_fails_when_provided_with_wrong_credentials(): void
    {
        $password = $this->faker->password();
        $user     = User::factory()->state(['password' => bcrypt($password)])->create();
        $res      = $this->json('post', '/api/login', [
            'email'    => $user->email,
            'password' => 'secret',
        ]);

        $res->assertStatus(Response::HTTP_UNAUTHORIZED);
        $res->assertJsonFragment(['message' => 'Invalid credentials.']);
    }

    /** @test */
    public function it_fails_when_not_provided_with_email_field(): void
    {
        $password = $this->faker->password();
        User::factory()->state(['password' => bcrypt($password)])->create();
        $res = $this->json('post', '/api/login', [
            'password' => $password,
        ]);

        $res->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $res->assertJsonFragment(['message' => 'The email field is required.']);
    }

    /** @test */
    public function it_fails_when_provided_with_wrong_email(): void
    {
        $password = $this->faker->password();
        User::factory()->state(['password' => bcrypt($password)])->create();
        $res = $this->json('post', '/api/login', [
            'email'    => $this->faker->email(),
            'password' => $password,
        ]);

        $res->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $res->assertJsonFragment(['message' => 'The selected email is invalid.']);
    }

    /** @test */
    public function it_fails_when_not_provided_with_password_field(): void
    {
        $password = $this->faker->password();
        $user     = User::factory()->state(['password' => bcrypt($password)])->create();
        $res      = $this->json('post', '/api/login', [
            'email' => $user->email,
        ]);

        $res->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $res->assertJsonFragment(['message' => 'The password field is required.']);
    }

    /** @test */
    public function it_fails_when_provided_with_password_length_less_than_six(): void
    {
        $password = $this->faker->password(1, 5);
        $user     = User::factory()->state(['password' => bcrypt($password)])->create();
        $res      = $this->json('post', '/api/login', [
            'email'    => $user->email,
            'password' => $password,
        ]);

        $res->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $res->assertJsonFragment(['message' => 'The password field must be at least 6 characters.']);
    }
}
