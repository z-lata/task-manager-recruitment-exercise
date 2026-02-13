<?php

declare(strict_types=1);

namespace App\Infrastructure\Tasks\Persistence\Doctrine\Contract\Factory;

use App\Application\Tasks\DTO\Model\TaskDetailsDTO;
use App\Application\Tasks\DTO\Model\TaskDTO;
use App\Infrastructure\Shared\Audit\Persistence\Doctrine\Entity\Event;
use App\Infrastructure\Tasks\Persistence\Doctrine\Entity\Task;

interface TaskFactoryInterface
{
    public function createTask(string $name, string $description, string $assignedUserUuid): Task;

    public function createTaskDTOFromEntity(Task $task): TaskDTO;

    /**
     * @param Event[] $events
     */
    public function createTaskDetailsDTOFromEntities(Task $task, array $events): TaskDetailsDTO;
}
