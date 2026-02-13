<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Audit\Messaging\EventDispatcher\Handler;

use App\Domain\Tasks\Event\AbstractTaskEvent;
use App\Infrastructure\Shared\Audit\Persistence\Store\EventStore;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[AsMessageHandler]
final readonly class TaskEventHandler
{
    public function __construct(
        private NormalizerInterface $normalizer,
        private EventStore $eventStore,
    ) {
    }

    public function __invoke(AbstractTaskEvent $event): void
    {
        /** @var mixed[] */
        $payloadArray = $this->normalizer->normalize($event->getPayload());

        $this->eventStore->createEvent(
            type: $event->getEventType(),
            occurredAt: $event->getOccurredAt(),
            actorUuid: $event->getActorUuid(),
            resourceUuid: $event->getResourceUuid(),
            payload: $payloadArray,
        );
    }
}
