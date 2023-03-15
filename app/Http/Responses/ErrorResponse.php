<?php

namespace App\Http\Responses;

class ErrorResponse extends \Illuminate\Http\JsonResponse
{
    public function __construct(
        string $message = 'Something went wrong.',
        array $data = [],
        int $status = 500,
        array $headers = [],
        int $options = 0,
        bool $json = false,
    ) {
        parent::__construct(['data' => $data, 'message' => $message], $status, $headers, $options, $json);
    }
}
