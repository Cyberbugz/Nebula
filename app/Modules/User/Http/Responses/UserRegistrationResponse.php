<?php

namespace App\Modules\User\Http\Responses;

use App\Base\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\User\Http\Resources\UserResource;
use App\Modules\User\Core\Events\UserRegistered;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response as SymphonyResponse;

class UserRegistrationResponse extends Response
{
    /**
     * @param  \App\Modules\User\Domain\ViewModels\Contracts\AuthenticatedUserModelInterface  $resource
     */
    protected function createResource(mixed $resource): JsonResponse|JsonResource|LengthAwarePaginator
    {
        return (new UserResource($resource->user()))
            ->additional(['token' => $resource->token()])
            ->response()
            ->setStatusCode(SymphonyResponse::HTTP_CREATED);
    }

    /**
     * @param  \App\Modules\User\Domain\ViewModels\Contracts\AuthenticatedUserModelInterface  $resource
     */
    protected function success(mixed $resource): void
    {
        UserRegistered::dispatch($resource->user());
    }
}
