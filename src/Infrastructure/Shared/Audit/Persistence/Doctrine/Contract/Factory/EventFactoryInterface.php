<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Audit\Persistence\Doctrine\Contract\Factory;

use App\Infrastructure\Shared\Audit\Persistence\Doctrine\Entity\Event;
use DateTimeImmutable;

interface EventFactoryInterface
{
    /**
     * @param mixed[]|null $payload
     */
    public function createEvent(
        string $type,
        DateTimeImmutable $occurredAt,
        ?string $actorUuid = null,
        ?string $resourceUuid = null,
        ?array $payload = null,
    ): Event;
}
