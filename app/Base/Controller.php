<?php

namespace App\Base;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Base\Contracts\ResponseInterface;
use App\Base\Contracts\RequestHandlerInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class Controller implements RequestHandlerInterface
{
    public function __construct(protected ResponseInterface $response, protected Request $request)
    {
    }

    public function __invoke(): LengthAwarePaginator|JsonResponse|JsonResource|StreamedResponse|RedirectResponse
    {
        return $this->response->send(
            $this,
            $this->request,
        );
    }
}
