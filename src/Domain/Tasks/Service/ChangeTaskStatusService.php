<?php

declare(strict_types=1);

namespace App\Domain\Tasks\Service;

use App\Domain\Tasks\Contract\Service\ChangeTaskStatusServiceInterface;
use App\Domain\Tasks\Event\TaskStatusUpdatedEvent;
use App\Domain\Tasks\Exception\TaskNotFoundException;
use App\Domain\Tasks\Exception\TaskOwnershipException;
use App\Domain\Tasks\Strategy\TaskStatus\TaskStatusStrategy;
use App\Infrastructure\Tasks\Messaging\Contract\EventDispatcher\Publisher\TaskEventPublisherInterface;
use App\Infrastructure\Tasks\Persistence\Doctrine\Entity\Task;
use App\Infrastructure\Tasks\Persistence\Store\TasksStore;
use Override;

final readonly class ChangeTaskStatusService implements ChangeTaskStatusServiceInterface
{
    public function __construct(
        private TaskStatusStrategy $taskStatusStrategy,
        private TaskEventPublisherInterface $taskEventPublisher,
        private TasksStore $tasksStore,
    ) {
    }

    #[Override]
    public function changeTaskStatus(string $userUuid, string $taskUuid, string $status): void
    {
        $task = $this->tasksStore->findTaskByUuid($taskUuid);

        if (! $task instanceof Task) {
            throw new TaskNotFoundException();
        }

        if ($userUuid !== $task->getAssignedUserUuid()) {
            throw new TaskOwnershipException();
        }

        $this->taskStatusStrategy->changeTaskStatus($task, $status);

        $event = new TaskStatusUpdatedEvent(actorUuid: $userUuid, resourceUuid: $task->getUuid(), payload: $task);
        $this->taskEventPublisher->publish($event);
    }
}
