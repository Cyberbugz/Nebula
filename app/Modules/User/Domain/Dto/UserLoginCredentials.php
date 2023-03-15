<?php

namespace App\Modules\User\Domain\Dto;

use Illuminate\Support\Fluent;

/**
 * @property string $email
 * @property string $password
 */
class UserLoginCredentials extends Fluent
{
}
