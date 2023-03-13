<?php

namespace App\Modules\User\Domain\ViewModels;

use Illuminate\Contracts\Auth\Authenticatable;
use App\Modules\User\Domain\ViewModels\Contracts\AuthenticatedUserModelInterface;

class AuthenticatedUserModel implements AuthenticatedUserModelInterface
{
    public function __construct(protected Authenticatable $user, protected string $token)
    {
    }

    public function user(): Authenticatable
    {
        return $this->user;
    }

    public function token(): string
    {
        return $this->token;
    }
}
