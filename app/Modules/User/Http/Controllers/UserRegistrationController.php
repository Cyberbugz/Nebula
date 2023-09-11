<?php

namespace App\Modules\User\Http\Controllers;

use Dust\Base\Controller;
use Dust\Http\Router\Attributes\Route;
use Dust\Http\Router\Enum\Http;
use Illuminate\Http\Request;
use Dust\Base\Contracts\ResponseInterface;
use App\Modules\User\Domain\Dto\UserRegistrationData;
use App\Modules\User\Core\Services\UserRegistrationService;
use App\Modules\User\Http\Requests\UserRegistrationRequest;
use App\Modules\User\Http\Responses\UserRegistrationResponse;

#[Route(Http::POST, 'register', 'api.users.register')]
class UserRegistrationController extends Controller
{
    public function __construct(UserRegistrationResponse $response, UserRegistrationRequest $request, protected UserRegistrationService $service)
    {
        parent::__construct($response, $request);
    }

    public function handle(ResponseInterface $response, Request $request): \App\Modules\User\Domain\ViewModels\Contracts\AuthenticatedUserModelInterface
    {
        return $this->service->handle(new UserRegistrationData($request->only(['first_name', 'last_name', 'email', 'password'])));
    }
}
