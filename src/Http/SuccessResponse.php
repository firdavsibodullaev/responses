<?php

namespace Firdavs\Responses\Http;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as SymphonyResponse;

class SuccessResponse implements Responsable
{
    public function __construct(
        private readonly SymphonyResponse|Responsable $response,
        private readonly string                       $message = '',
        private readonly int                          $status = 200
    )
    {
    }

    public function toResponse($request): SymphonyResponse
    {
        $response = [
            'success' => true,
            'message' => $this->message,
            'data' => $this->getData(),
        ];

        if ($pagination = $this->getPaginationFromResource()) {
            $response = $response + $pagination;
        }

        return Response::make(
            content: $response,
            status: $this->status
        );
    }

    private function getData()
    {
        return $this->response instanceof SymphonyResponse
            ? json_decode($this->response->getContent(), true)
            : $this->response;
    }

    private function getPaginationFromResource(): bool|array
    {
        if (!($this->response instanceof JsonResource && $this->response->resource instanceof AbstractPaginator)) {
            return false;
        }

        $paginated = $this->response->resource->toArray();

        return [
            'links' => $this->paginationLinks($paginated),
            'meta' => $this->meta($paginated),
        ];
    }

    private function paginationLinks(array $paginated): array
    {
        return [
            'first' => $paginated['first_page_url'] ?? null,
            'last' => $paginated['last_page_url'] ?? null,
            'prev' => $paginated['prev_page_url'] ?? null,
            'next' => $paginated['next_page_url'] ?? null,
        ];
    }

    private function meta(array $paginated): array
    {
        return Arr::except($paginated, [
            'data',
            'first_page_url',
            'last_page_url',
            'prev_page_url',
            'next_page_url',
        ]);
    }
}
