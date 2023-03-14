<?php

namespace App\Modules\User\Domain\Dto;

use Illuminate\Support\Fluent;

/**
 * @property string $first_name,
 * @property string $last_name,
 * @property string $email,
 * @property string $password
 */
class UserRegistrationData extends Fluent
{}
