<?php

namespace App\Modules\User\Core\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use App\Modules\User\Domain\Entities\User;
use App\Modules\User\Domain\Dto\UserLoginCredentials;
use App\Modules\User\Domain\Repositories\UserRepository;
use App\Modules\User\Domain\ViewModels\AuthenticatedUserModel;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Modules\User\Domain\ViewModels\Contracts\AuthenticatedUserModelInterface;

final class UserLoginService
{
    public function __construct(protected UserRepository $repository)
    {
    }

    public function handle(UserLoginCredentials $credentials): AuthenticatedUserModelInterface
    {
        if (
            ! ($user = $this->getUser($credentials->email)) ||
            ! Hash::check($credentials->password, $user->password)
        ) {
            throw new UnauthorizedHttpException('Basic', 'Invalid credentials.');
        }

        return new AuthenticatedUserModel(
            $user,
            $user->createToken(Config::get('app.name'))->plainTextToken
        );
    }

    protected function getUser(string $email): User|Model|null
    {
        return $this->repository->where('email', $email)->first();
    }
}
