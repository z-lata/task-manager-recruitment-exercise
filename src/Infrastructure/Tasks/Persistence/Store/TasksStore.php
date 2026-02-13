<?php

declare(strict_types=1);

namespace App\Infrastructure\Tasks\Persistence\Store;

use App\Application\Tasks\DTO\Model\TaskDTO;
use App\Infrastructure\Tasks\Persistence\Doctrine\Contract\Factory\TaskFactoryInterface;
use App\Infrastructure\Tasks\Persistence\Doctrine\Contract\Repository\TaskRepositoryInterface;
use App\Infrastructure\Tasks\Persistence\Doctrine\Entity\Task;

final readonly class TasksStore
{
    public function __construct(
        private TaskFactoryInterface $taskFactory,
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
        $tasks = $this->taskRepository->fetchTasksAssignedToUser($userUuid);

        return array_map(callback: $this->taskFactory->createTaskDTOFromEntity(...), array: $tasks);
    }
}
