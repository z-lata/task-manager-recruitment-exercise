<?php

declare(strict_types=1);

namespace App\Domain\Tasks\Strategy\TaskStatus;

use App\Domain\Tasks\Strategy\TaskStatus\Contract\TaskStatusStrategyInterface;
use App\Domain\Tasks\Strategy\TaskStatus\Strategies\TaskDoneStatusStrategy;
use App\Domain\Tasks\Strategy\TaskStatus\Strategies\TaskInProgressStatusStrategy;
use App\Domain\Tasks\Strategy\TaskStatus\Strategies\TaskToDoStatusStrategy;
use App\Infrastructure\Tasks\Persistence\Doctrine\Entity\Task;
use App\Infrastructure\Tasks\Persistence\Doctrine\Enum\TaskStatusEnum;
use InvalidArgumentException;
use Override;

final readonly class TaskStatusStrategy implements TaskStatusStrategyInterface
{
    public function __construct(
        private TaskToDoStatusStrategy $taskToDoStatusStrategy,
        private TaskInProgressStatusStrategy $taskInProgressStatusStrategy,
        private TaskDoneStatusStrategy $taskDoneStatusStrategy,
    ) {
    }

    #[Override]
    public function changeTaskStatus(Task $task, string $status): void
    {
        match (true) {
            TaskStatusEnum::TO_DO->value === $task->getStatus()->value => $this->taskToDoStatusStrategy->changeTaskStatus(
                $task,
                $status,
            ),
            TaskStatusEnum::IN_PROGRESS->value === $task->getStatus()->value => $this->taskInProgressStatusStrategy->changeTaskStatus(
                $task,
                $status,
            ),
            TaskStatusEnum::DONE->value === $task->getStatus()->value => $this->taskDoneStatusStrategy->changeTaskStatus(
                $task,
                $status,
            ),
            default => throw new InvalidArgumentException('Unsupported status.'),
        };
    }
}
