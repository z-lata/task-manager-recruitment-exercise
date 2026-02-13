<?php

declare(strict_types=1);

namespace App\Infrastructure\Tasks\Persistence\Doctrine\Factory;

use App\Application\Tasks\DTO\Model\TaskDetailsDTO;
use App\Application\Tasks\DTO\Model\TaskDTO;
use App\Application\Tasks\DTO\Model\TaskEventDTO;
use App\Infrastructure\Shared\Audit\Persistence\Doctrine\Entity\Event;
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

    private function createTaskEventDTOFromEntity(Event $event): TaskEventDTO
    {
        /** @var mixed[] */
        $payloadArray = $event->getPayload();

        return new TaskEventDTO(
            uuid: $event->getUuid(),
            type: $event->getType(),
            occurredAt: $event->getOccurredAt(),
            payload: $payloadArray,
        );
    }

    #[Override]
    public function createTaskDetailsDTOFromEntities(Task $task, array $events): TaskDetailsDTO
    {
        $taskDTO = $this->createTaskDTOFromEntity($task);
        $taskEvents = array_map(callback: $this->createTaskEventDTOFromEntity(...), array: $events);

        return new TaskDetailsDTO(task: $taskDTO, events: $taskEvents);
    }
}
