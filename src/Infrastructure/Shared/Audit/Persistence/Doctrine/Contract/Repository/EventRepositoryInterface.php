<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Audit\Persistence\Doctrine\Contract\Repository;

use App\Infrastructure\Shared\Audit\Persistence\Doctrine\Entity\Event;

interface EventRepositoryInterface
{
    public function saveEvent(Event $event): void;

    /**
     * @return Event[]
     */
    public function findEventsByResourceUuid(string $resourceUuid): array;
}
