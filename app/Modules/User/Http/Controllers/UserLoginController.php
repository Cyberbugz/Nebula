<?php

namespace App\Modules\User\Http\Controllers;

use Dust\Base\Controller;
use Dust\Http\Router\Attributes\Route;
use Dust\Http\Router\Enum\Http;
use Illuminate\Http\Request;
use Dust\Base\Contracts\ResponseInterface;
use App\Modules\User\Core\Services\UserLoginService;
use App\Modules\User\Http\Requests\UserLoginRequest;
use App\Modules\User\Domain\Dto\UserLoginCredentials;
use App\Modules\User\Http\Responses\UserLoginResponse;
use App\Modules\User\Domain\ViewModels\Contracts\AuthenticatedUserModelInterface;

#[Route(Http::POST, 'login', 'api.users.login')]
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
