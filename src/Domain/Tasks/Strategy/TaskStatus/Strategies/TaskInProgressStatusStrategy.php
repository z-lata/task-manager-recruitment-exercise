<?php

declare(strict_types=1);

namespace App\Domain\Tasks\Strategy\TaskStatus\Strategies;

use App\Domain\Tasks\Strategy\TaskStatus\Contract\TaskStatusStrategyInterface;
use App\Infrastructure\Tasks\Persistence\Doctrine\Entity\Task;
use App\Infrastructure\Tasks\Persistence\Doctrine\Enum\TaskStatusEnum;
use InvalidArgumentException;
use Override;

final readonly class TaskInProgressStatusStrategy implements TaskStatusStrategyInterface
{
    #[Override]
    public function changeTaskStatus(Task $task, string $status): void
    {
        if (TaskStatusEnum::IN_PROGRESS->value === $status) {
            throw new InvalidArgumentException('Task is already in this status.');
        }

        $task->setStatus(TaskStatusEnum::from($status));
    }
}
