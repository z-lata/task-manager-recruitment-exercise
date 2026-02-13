<?php

declare(strict_types=1);

namespace App\Infrastructure\Tasks\Persistence\Doctrine\Factory;

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
}
