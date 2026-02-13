<?php

declare(strict_types=1);

namespace App\Infrastructure\Tasks\Persistence\Doctrine\Repository;

use App\Infrastructure\Tasks\Persistence\Doctrine\Contract\Repository\TaskRepositoryInterface;
use App\Infrastructure\Tasks\Persistence\Doctrine\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Override;

/**
 * @extends ServiceEntityRepository<Task>
 */
final class TaskRepository extends ServiceEntityRepository implements TaskRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    #[Override]
    public function saveTask(Task $task): void
    {
        $this->getEntityManager()
            ->persist($task)
        ;
        $this->getEntityManager()
            ->flush()
        ;
    }

    #[Override]
    public function findTaskByUuid(string $uuid): ?Task
    {
        return $this->findOneBy([
            'uuid' => $uuid,
        ]);
    }
}
