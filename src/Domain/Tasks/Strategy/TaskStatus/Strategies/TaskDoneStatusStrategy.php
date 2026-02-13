<?php

declare(strict_types=1);

namespace App\Domain\Tasks\Strategy\TaskStatus\Strategies;

use App\Domain\Tasks\Strategy\TaskStatus\Contract\TaskStatusStrategyInterface;
use App\Infrastructure\Tasks\Persistence\Doctrine\Entity\Task;
use App\Infrastructure\Tasks\Persistence\Doctrine\Enum\TaskStatusEnum;
use InvalidArgumentException;
use Override;

final readonly class TaskDoneStatusStrategy implements TaskStatusStrategyInterface
{
    #[Override]
    public function changeTaskStatus(Task $task, string $status): void
    {
        if (TaskStatusEnum::DONE->value === $status) {
            throw new InvalidArgumentException('Task is already in this status.');
        }

        if (TaskStatusEnum::TO_DO->value === $status) {
            throw new InvalidArgumentException(sprintf(
                'Can not change task status to "%s".',
                TaskStatusEnum::TO_DO->value,
            ));
        }

        $task->setStatus(TaskStatusEnum::from($status));
    }
}
