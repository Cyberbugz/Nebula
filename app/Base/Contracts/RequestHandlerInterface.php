<?php

namespace App\Base\Contracts;

use Illuminate\Http\Request;

interface RequestHandlerInterface
{
    public function handle(ResponseInterface $response, Request $request): mixed;
}
