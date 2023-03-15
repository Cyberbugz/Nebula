<?php

namespace App\Modules\User\Http\Controllers;

use App\Base\Contracts\ResponseInterface;
use App\Base\Controller;
use App\Modules\User\Http\Requests\GetUserSubscriptionRequest;
use App\Modules\User\Http\Responses\GetUserSubscriptionResponse;
use App\Modules\User\Services\GetUserSubscriptionService;
use Illuminate\Http\Request;

class GetUserSubscriptionController extends Controller
{
    public function __construct(GetUserSubscriptionResponse $response, GetUserSubscriptionRequest $request, protected GetUserSubscriptionService $service)
    {
        parent::__construct($response, $request);
    }

    public function handle(ResponseInterface $response, Request $request): mixed
    {
        //
    }
}
