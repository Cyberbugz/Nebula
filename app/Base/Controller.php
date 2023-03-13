<?php

namespace App\Base;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Base\Contracts\ResponseInterface;
use App\Base\Contracts\RequestHandlerInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class Controller implements RequestHandlerInterface
{
    public function __construct(protected ResponseInterface $response, protected Request $request)
    {
    }

    public function __invoke(): LengthAwarePaginator|JsonResponse|JsonResource
    {
        return $this->response->send(
            $this,
            $this->request,
        );
    }
}
