<?php

declare(strict_types=1);

namespace App\Domain\Tasks\Service;

use App\Domain\Tasks\Contract\Service\CreateTaskServiceInterface;
use App\Domain\Tasks\Event\TaskCreatedEvent;
use App\Infrastructure\Tasks\Messaging\Contract\EventDispatcher\Publisher\TaskEventPublisherInterface;
use App\Infrastructure\Tasks\Persistence\Store\TasksStore;
use Override;

final readonly class CreateTaskService implements CreateTaskServiceInterface
{
    public function __construct(
        private TaskEventPublisherInterface $taskEventPublisher,
        private TasksStore $tasksStore,
    ) {
    }

    #[Override]
    public function createTask(string $userUuid, string $name, string $description): void
    {
        $task = $this->tasksStore->createTask(assignedUserUuid: $userUuid, name: $name, description: $description);

        $event = new TaskCreatedEvent(actorUuid: $userUuid, resourceUuid: $task->getUuid(), payload: $task);
        $this->taskEventPublisher->publish($event);
    }
}
