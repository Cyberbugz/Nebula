<?php

namespace App\Modules\User\Http\Responses;

use Throwable;
use App\Base\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Responses\ErrorResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\User\Http\Resources\UserResource;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UserLoginResponse extends Response
{
    /**
     * @param    \App\Modules\User\Domain\ViewModels\Contracts\AuthenticatedUserModelInterface    $resource
     */
    protected function createResource(mixed $resource): JsonResource
    {
        return (new UserResource($resource->user()))
            ->additional(['token' => $resource->token()]);
    }

    protected function handleErrorResponse(Throwable $e): bool|JsonResponse
    {
        if ($e instanceof UnauthorizedHttpException) {
            return new ErrorResponse($e->getMessage(), status: $e->getStatusCode());
        }

        return false;
    }
}
