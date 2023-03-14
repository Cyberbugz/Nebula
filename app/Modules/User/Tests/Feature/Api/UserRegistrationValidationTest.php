<?php

namespace App\Modules\User\Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Support\Str;
use App\Modules\User\Domain\Entities\User;
use Symfony\Component\HttpFoundation\Response;

class UserRegistrationValidationTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider validations
     * @group        user
     */
    public function it_validates_user_registration_inputs($given, $errorField, $expected): void
    {
        User::query()
        ->firstOrCreate(User::factory()->state(['email' => 'john.doe@example.com'])->make()->toArray());
        $res = $this->json('post', '/api/register', $given);
        $res->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $res->assertJsonValidationErrorFor($errorField);
        $res->assertJsonFragment([$expected]);
    }

    public function validations(): array
    {
        return [
            'first name field is required' => [
                [],
                'first_name',
                'The first name field is required.',
            ],
            'first name minimum length is 2' => [
                ['first_name' => Str::random(1)],
                'first_name',
                'The first name field must be at least 2 characters.',
            ],
            'first name must be string' => [
                ['first_name' => rand()],
                'first_name',
                'The first name field must be a string.',
            ],
            'first name maximum length is 40' => [
                ['first_name' => Str::random(41)],
                'first_name',
                'The first name field must not be greater than 40 characters.',
            ],
            'last name field is required' => [
                [],
                'last_name',
                'The last name field is required.',
            ],
            'last name must be string' => [
                ['last_name' => rand()],
                'last_name',
                'The last name field must be a string.',
            ],
            'last name maximum length is 40' => [
                ['last_name' => Str::random(41)],
                'last_name',
                'The last name field must not be greater than 40 characters.',
            ],
            'email field is required' => [
                [],
                'email',
                'The email field is required.',
            ],
            'email field is invalid email address'             => [
                ['email' => Str::random()],
                'email',
                'The email field must be a valid email address.',
            ],
            'email has already been taken'             => [
                ['email' => 'john.doe@example.com'],
                'email',
                'The email has already been taken.',
            ],
            'email maximum length is 100'             => [
                ['email' => Str::random(100) . '@example.com'],
                'email',
                'The email field must not be greater than 100 characters.',
            ],
            'password field is required'         => [
                [],
                'password',
                'The password field is required.',
            ],
            'password field minimum length is 6' => [
                ['password' => Str::password(5)],
                'password',
                'The password field must be at least 6 characters.',
            ],
            'password field must be confirmed' => [
                ['password' => Str::password(6)],
                'password',
                'The password field confirmation does not match.',
            ],
        ];
    }
}
