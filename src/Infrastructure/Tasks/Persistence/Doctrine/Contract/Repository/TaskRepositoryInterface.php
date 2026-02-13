<?php

declare(strict_types=1);

namespace App\Infrastructure\Tasks\Persistence\Doctrine\Contract\Repository;

use App\Infrastructure\Tasks\Persistence\Doctrine\Entity\Task;

interface TaskRepositoryInterface
{
    public function saveTask(Task $task): void;

    public function findTaskByUuid(string $uuid): ?Task;

    /**
     * @return Task[]
     */
    public function fetchTasksAssignedToUser(string $userUuid): array;
}
