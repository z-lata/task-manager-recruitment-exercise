<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Audit\Persistence\Doctrine\Factory;

use App\Infrastructure\Shared\Audit\Persistence\Doctrine\Contract\Factory\EventFactoryInterface;
use App\Infrastructure\Shared\Audit\Persistence\Doctrine\Entity\Event;
use DateTimeImmutable;
use Override;

final readonly class EventFactory implements EventFactoryInterface
{
    #[Override]
    public function createEvent(
        string $type,
        DateTimeImmutable $occurredAt,
        ?string $actorUuid = null,
        ?string $resourceUuid = null,
        ?array $payload = null,
    ): Event {
        return new Event(
            type: $type,
            occurredAt: $occurredAt,
            actorUuid: $actorUuid,
            resourceUuid: $resourceUuid,
            payload: $payload,
        );
    }
}
