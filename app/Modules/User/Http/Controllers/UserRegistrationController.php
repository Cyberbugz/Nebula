<?php

namespace App\Modules\User\Http\Controllers;

use App\Base\Controller;
use Illuminate\Http\Request;
use App\Base\Contracts\ResponseInterface;
use App\Modules\User\Domain\Dto\UserRegistrationData;
use App\Modules\User\Http\Requests\UserRegistrationRequest;
use App\Modules\User\Http\Responses\UserRegistrationResponse;
use App\Modules\User\Core\Services\UserRegistrationService;

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
