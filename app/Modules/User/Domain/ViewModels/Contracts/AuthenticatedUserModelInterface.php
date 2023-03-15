<?php

namespace App\Modules\User\Domain\ViewModels\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

interface AuthenticatedUserModelInterface
{
    public function user(): Authenticatable;

    public function token(): string;
}
