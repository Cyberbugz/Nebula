<?php

namespace App\Modules\User\Http\Responses;

use App\Base\Response;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class GetUserSubscriptionResponse extends Response
{
    protected function createResource(mixed $resource): JsonResponse|JsonResource|LengthAwarePaginator
    {
        //
    }
}
