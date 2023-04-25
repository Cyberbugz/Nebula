<?php

namespace App\Modules\User\Core\Services;

use Illuminate\Support\Facades\Config;
use App\Modules\User\Domain\Dto\UserRegistrationData;
use App\Modules\User\Domain\Repositories\UserRepository;
use App\Modules\User\Domain\ViewModels\AuthenticatedUserModel;
use App\Modules\User\Domain\ViewModels\Contracts\AuthenticatedUserModelInterface;

final class UserRegistrationService
{
    public function __construct(protected UserRepository $repository)
    {
    }

    public function handle(UserRegistrationData $data): AuthenticatedUserModelInterface
    {
        $data->offsetSet('password', bcrypt($data->password));

        /** @var \App\Modules\User\Domain\Entities\User $user */
        $user = $this->repository->create($data->toArray());

        return new AuthenticatedUserModel(
            $user,
            $user->createToken(Config::get('app.name'))->plainTextToken
        );
    }
}
