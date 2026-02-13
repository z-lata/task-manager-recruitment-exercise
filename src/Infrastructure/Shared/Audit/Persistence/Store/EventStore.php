<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Audit\Persistence\Store;

use App\Infrastructure\Shared\Audit\Persistence\Doctrine\Contract\Factory\EventFactoryInterface;
use App\Infrastructure\Shared\Audit\Persistence\Doctrine\Contract\Repository\EventRepositoryInterface;
use App\Infrastructure\Shared\Audit\Persistence\Doctrine\Entity\Event;
use DateTimeImmutable;

final readonly class EventStore
{
    public function __construct(
        private EventFactoryInterface $eventFactory,
        private EventRepositoryInterface $eventRepository,
    ) {
    }

    /**
     * @param mixed[]|null $payload
     */
    public function createEvent(
        string $type,
        DateTimeImmutable $occurredAt,
        ?string $actorUuid = null,
        ?string $resourceUuid = null,
        ?array $payload = null,
    ): void {
        $event = $this->eventFactory->createEvent(
            type: $type,
            occurredAt: $occurredAt,
            actorUuid: $actorUuid,
            resourceUuid: $resourceUuid,
            payload: $payload,
        );
        $this->eventRepository->saveEvent($event);
    }

    /**
     * @return Event[]
     */
    public function findEventsByResourceUuid(string $resourceUuid): array
    {
        return $this->eventRepository->findEventsByResourceUuid($resourceUuid);
    }
}
