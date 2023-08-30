<?php

namespace Firdavsi\Responses\Http;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class SuccessEmptyResponse implements Responsable
{
    public function __construct(
        private readonly string $message,
        private readonly int    $status = 200
    )
    {
    }

    public function toResponse($request): SymfonyResponse
    {
        return Response::make(
            content: [
                'success' => true,
                'message' => $this->message
            ],
            status: $this->status
        );
    }
}
