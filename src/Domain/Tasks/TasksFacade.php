<?php

declare(strict_types=1);

namespace App\Domain\Tasks;

use App\Application\Tasks\DTO\Model\TaskDetailsDTO;
use App\Application\Tasks\DTO\Model\TaskDTO;
use App\Domain\Tasks\Contract\Service\ChangeTaskStatusServiceInterface;
use App\Domain\Tasks\Contract\Service\CreateTaskServiceInterface;
use App\Infrastructure\Tasks\Persistence\Store\TasksStore;

final readonly class TasksFacade
{
    public function __construct(
        private CreateTaskServiceInterface $createTaskService,
        private ChangeTaskStatusServiceInterface $changeTaskStatusService,
        private TasksStore $tasksStore,
    ) {
    }

    public function createTask(string $userUuid, string $name, string $description): void
    {
        $this->createTaskService->createTask(userUuid: $userUuid, name: $name, description: $description);
    }

    public function changeTaskStatus(string $userUuid, string $taskUuid, string $status): void
    {
        $this->changeTaskStatusService->changeTaskStatus(
            userUuid: $userUuid,
            taskUuid: $taskUuid,
            status: $status,
        );
    }

    /**
     * @return TaskDTO[]
     */
    public function fetchTasksAssignedToUser(string $userUuid): array
    {
        return $this->tasksStore->fetchTasksAssignedToUser($userUuid);
    }

    /**
     * @return TaskDTO[]
     */
    public function fetchTasks(): array
    {
        return $this->tasksStore->fetchTasks();
    }

    public function fetchTaskDetailsAssignedToUser(
        string $taskUuid,
        string $userUuid,
        bool $isAdmin,
    ): TaskDetailsDTO {
        return $this->tasksStore->fetchTaskDetailsAssignedToUser(
            taskUuid: $taskUuid,
            userUuid: $userUuid,
            isAdmin: $isAdmin,
        );
    }
}
