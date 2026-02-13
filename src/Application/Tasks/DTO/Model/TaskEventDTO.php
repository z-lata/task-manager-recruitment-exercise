<?php

declare(strict_types=1);

namespace App\Application\Tasks\DTO\Model;

use DateTimeImmutable;
use DateTimeInterface;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

final readonly class TaskEventDTO
{
    /**
     * @param mixed[] $payload
     */
    public function __construct(
        private string $uuid,
        private string $type,
        #[Context(context: [
            DateTimeNormalizer::FORMAT_KEY => DateTimeInterface::RFC3339,
        ])]
        private DateTimeImmutable $occurredAt,
        private array $payload,
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getOccurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }

    /**
     * @return mixed[]
     */
    public function getPayload(): array
    {
        return $this->payload;
    }
}
