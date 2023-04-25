<?php

namespace App\Modules\User\Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class UserLoginValidationTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider validations
     *
     * @group        user
     */
    public function it_validates_user_login_inputs($given, $errorField, $expected)
    {
        $res = $this->json('post', route('api.users.login'), $given);

        $res->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $res->assertJsonValidationErrorFor($errorField);
        $res->assertJsonFragment([$expected]);
    }

    public static function validations(): array
    {
        return [
            'email field is required'              => [
                [],
                'email',
                'The email field is required.',
            ],
            'email field is invalid email address' => [
                ['email' => Str::random()],
                'email',
                'The email field must be a valid email address.',
            ],
            'email maximum length is 100'          => [
                ['email' => Str::random(100).'@example.com'],
                'email',
                'The email field must not be greater than 100 characters.',
            ],
            'password field is required'           => [
                [],
                'password',
                'The password field is required.',
            ],
            'password field minimum length is 6'   => [
                ['password' => Str::password(5)],
                'password',
                'The password field must be at least 6 characters.',
            ],
        ];
    }
}
