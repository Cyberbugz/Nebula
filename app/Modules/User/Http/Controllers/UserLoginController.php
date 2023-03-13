<?php

namespace App\Modules\User\Http\Controllers;

use App\Base\Controller;
use Illuminate\Http\Request;
use App\Base\Contracts\ResponseInterface;
use App\Modules\User\Services\UserLoginService;
use App\Modules\User\Http\Requests\UserLoginRequest;
use App\Modules\User\Domain\Dto\UserLoginCredentials;
use App\Modules\User\Http\Responses\UserLoginResponse;
use App\Modules\User\Domain\ViewModels\Contracts\AuthenticatedUserModelInterface;

class UserLoginController extends Controller
{
    public function __construct(UserLoginResponse $userLoginResponse, UserLoginRequest $userLoginRequest, protected UserLoginService $service)
    {
        parent::__construct($userLoginResponse, $userLoginRequest);
    }

    public function handle(ResponseInterface $response, Request $request): AuthenticatedUserModelInterface
    {
        return $this->service->handle(new UserLoginCredentials($request->only(['email', 'password'])));
    }
}
