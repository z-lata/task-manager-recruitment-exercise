<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Audit\Persistence\Doctrine\Repository;

use App\Infrastructure\Shared\Audit\Persistence\Doctrine\Contract\Repository\EventRepositoryInterface;
use App\Infrastructure\Shared\Audit\Persistence\Doctrine\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Override;

/**
 * @extends ServiceEntityRepository<Event>
 */
final class EventRepository extends ServiceEntityRepository implements EventRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    #[Override]
    public function saveEvent(Event $event): void
    {
        $this->getEntityManager()
            ->persist($event)
        ;
        $this->getEntityManager()
            ->flush()
        ;
    }

    #[Override]
    public function findEventsByResourceUuid(string $resourceUuid): array
    {
        return $this->findBy([
            'resourceUuid' => $resourceUuid,
        ]);
    }
}
