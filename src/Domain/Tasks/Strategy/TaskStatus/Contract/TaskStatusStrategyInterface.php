<?php

declare(strict_types=1);

namespace App\Domain\Tasks\Strategy\TaskStatus\Contract;

use App\Infrastructure\Tasks\Persistence\Doctrine\Entity\Task;

interface TaskStatusStrategyInterface
{
    public function changeTaskStatus(Task $task, string $status): void;
}
