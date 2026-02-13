<?php

declare(strict_types=1);

namespace App\Infrastructure\Tasks\Messaging\EventDispatcher\Publisher;

use App\Domain\Tasks\Event\AbstractTaskEvent;
use App\Infrastructure\Tasks\Messaging\Contract\EventDispatcher\Publisher\TaskEventPublisherInterface;
use Override;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class TaskEventPublisher implements TaskEventPublisherInterface
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
    }

    #[Override]
    public function publish(AbstractTaskEvent $event): void
    {
        $this->messageBus->dispatch($event);
    }
}
