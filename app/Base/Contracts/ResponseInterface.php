<?php

namespace App\Base\Contracts;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ResponseInterface
{
    public function send(RequestHandlerInterface $handler, Request $request): JsonResponse|JsonResource|LengthAwarePaginator;

    public function silent(): static;

    /**
     * @throws \App\Exceptions\Response\EventInjectionRestrictedException
     */
    public function onSuccess(callable $handler): static;

    /**
     * @throws \App\Exceptions\Response\EventInjectionRestrictedException
     */
    public function onFailure(callable $handler): static;

    public function onLog(Closure $handler): static;
}
