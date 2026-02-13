<?php

declare(strict_types=1);

namespace App\Domain\Tasks\Event;

use DateTimeImmutable;
use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage(transport: 'sync')]
abstract readonly class AbstractTaskEvent
{
    private DateTimeImmutable $occurredAt;

    private string $eventType;

    public function __construct(
        private string $actorUuid,
        private string $resourceUuid,
        private object $payload,
    ) {
        $this->occurredAt = new DateTimeImmutable();
        $this->eventType = 'task.default';
    }

    public function getEventType(): string
    {
        return $this->eventType;
    }

    public function getActorUuid(): string
    {
        return $this->actorUuid;
    }

    public function getResourceUuid(): string
    {
        return $this->resourceUuid;
    }

    public function getPayload(): object
    {
        return $this->payload;
    }

    public function getOccurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
