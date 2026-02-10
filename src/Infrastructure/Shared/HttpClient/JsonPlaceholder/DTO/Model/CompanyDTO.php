<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\HttpClient\JsonPlaceholder\DTO\Model;

final readonly class CompanyDTO
{
    public function __construct(
        private string $name,
        private string $catchPhrase,
        private string $bs,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCatchPhrase(): string
    {
        return $this->catchPhrase;
    }

    public function getBs(): string
    {
        return $this->bs;
    }
}
