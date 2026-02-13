<?php

declare(strict_types=1);

namespace App\Infrastructure\Tasks\Persistence\Store;

use App\Application\Tasks\DTO\Model\TaskDetailsDTO;
use App\Application\Tasks\DTO\Model\TaskDTO;
use App\Domain\Tasks\Exception\TaskNotFoundException;
use App\Domain\Tasks\Exception\TaskOwnershipException;
use App\Infrastructure\Shared\Audit\Persistence\Store\EventStore;
use App\Infrastructure\Tasks\Persistence\Doctrine\Contract\Factory\TaskFactoryInterface;
use App\Infrastructure\Tasks\Persistence\Doctrine\Contract\Repository\TaskRepositoryInterface;
use App\Infrastructure\Tasks\Persistence\Doctrine\Entity\Task;

final readonly class TasksStore
{
    public function __construct(
        private TaskFactoryInterface $taskFactory,
        private EventStore $eventStore,
        private TaskRepositoryInterface $taskRepository,
    ) {
    }

    public function createTask(string $assignedUserUuid, string $name, string $description): Task
    {
        $task = $this->taskFactory->createTask(
            name: $name,
            description: $description,
            assignedUserUuid: $assignedUserUuid,
        );
        $this->taskRepository->saveTask($task);

        return $task;
    }

    public function findTaskByUuid(string $uuid): ?Task
    {
        return $this->taskRepository->findTaskByUuid($uuid);
    }

    /**
     * @return TaskDTO[]
     */
    public function fetchTasksAssignedToUser(string $userUuid): array
    {
        $tasks = $this->taskRepository->findTasksAssignedToUser($userUuid);

        return array_map(callback: $this->taskFactory->createTaskDTOFromEntity(...), array: $tasks);
    }

    /**
     * @return TaskDTO[]
     */
    public function fetchTasks(): array
    {
        $tasks = $this->taskRepository->findTasks();

        return array_map(callback: $this->taskFactory->createTaskDTOFromEntity(...), array: $tasks);
    }

    public function fetchTaskDetailsAssignedToUser(
        string $taskUuid,
        string $userUuid,
        bool $isAdmin,
    ): TaskDetailsDTO {
        $task = $this->taskRepository->findTaskByUuid($taskUuid);

        if (! $task instanceof Task) {
            throw new TaskNotFoundException();
        }

        $isOwner = $userUuid === $task->getAssignedUserUuid();

        if (! $isOwner && ! $isAdmin) {
            throw new TaskOwnershipException();
        }

        $events = $this->eventStore->findEventsByResourceUuid($task->getUuid());

        return $this->taskFactory->createTaskDetailsDTOFromEntities(task: $task, events: $events);
    }
}
