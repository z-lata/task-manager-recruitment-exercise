<?php

declare(strict_types=1);

namespace App\Application\Tasks\DTO\Model;

final readonly class TaskDetailsDTO
{
    /**
     * @param TaskEventDTO[] $events
     */
    public function __construct(
        private TaskDTO $task,
        private array $events,
    ) {
    }

    public function getTask(): TaskDTO
    {
        return $this->task;
    }

    /**
     * @return TaskEventDTO[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }
}
