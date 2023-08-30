<?php

namespace Firdavsi\Responses\Http;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class ErrorResponse implements Responsable
{
    public function __construct(
        private readonly string $message = '',
        private readonly int    $status = 400
    )
    {
    }

    public function toResponse($request): SymfonyResponse
    {
        return Response::make(
            content: [
                'success' => false,
                'message' => $this->message
            ],
            status: $this->status
        );
    }
}
