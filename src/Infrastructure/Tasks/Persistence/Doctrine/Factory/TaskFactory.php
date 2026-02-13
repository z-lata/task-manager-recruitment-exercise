<?php

declare(strict_types=1);

namespace App\Infrastructure\Tasks\Persistence\Doctrine\Factory;

use App\Application\Tasks\DTO\Model\TaskDTO;
use App\Infrastructure\Tasks\Persistence\Doctrine\Contract\Factory\TaskFactoryInterface;
use App\Infrastructure\Tasks\Persistence\Doctrine\Entity\Task;
use Override;

final readonly class TaskFactory implements TaskFactoryInterface
{
    #[Override]
    public function createTask(string $name, string $description, string $assignedUserUuid): Task
    {
        return new Task(name: $name, description: $description, assignedUserUuid: $assignedUserUuid);
    }

    #[Override]
    public function createTaskDTOFromEntity(Task $task): TaskDTO
    {
        return new TaskDTO(
            uuid: $task->getUuid(),
            status: $task->getStatus()
                ->value,
            name: $task->getName(),
            description: $task->getDescription(),
            assignedUserUuid: $task->getAssignedUserUuid(),
        );
    }
}
