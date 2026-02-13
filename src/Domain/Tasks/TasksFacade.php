<?php

declare(strict_types=1);

namespace App\Domain\Tasks;

use App\Domain\Tasks\Contract\Service\ChangeTaskStatusServiceInterface;
use App\Domain\Tasks\Contract\Service\CreateTaskServiceInterface;

final readonly class TasksFacade
{
    public function __construct(
        private CreateTaskServiceInterface $createTaskService,
        private ChangeTaskStatusServiceInterface $changeTaskStatusService,
        // private TasksStore $tasksStore,
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
}
