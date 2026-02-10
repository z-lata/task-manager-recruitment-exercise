<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\HttpClient\JsonPlaceholder\DTO\Model;

final readonly class GeoDTO
{
    public function __construct(
        private string $lat,
        private string $lng,
    ) {
    }

    public function getLat(): string
    {
        return $this->lat;
    }

    public function getLng(): string
    {
        return $this->lng;
    }
}
