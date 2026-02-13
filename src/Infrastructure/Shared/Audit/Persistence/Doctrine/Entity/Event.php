<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Audit\Persistence\Doctrine\Entity;

use App\Infrastructure\Shared\Audit\Persistence\Doctrine\Repository\EventRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ORM\Table(name: 'event', schema: 'audit')]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'id', type: Types::BIGINT, unique: true, nullable: false, options: [
        'unsigned' => true,
    ])]
    private int $id;

    #[ORM\Column(name: 'uuid', type: Types::GUID, unique: true, nullable: false)]
    private string $uuid;

    public function __construct(
        #[ORM\Column(name: 'type', type: Types::STRING, nullable: false)]
        private string $type,
        #[ORM\Column(name: 'occurred_at', type: Types::DATETIME_IMMUTABLE, nullable: false)]
        private DateTimeImmutable $occurredAt,
        #[ORM\Column(name: 'actor_uuid', type: Types::GUID, nullable: true, options: [
            'default' => null,
        ])]
        private ?string $actorUuid = null,
        #[ORM\Column(name: 'resource_uuid', type: Types::GUID, nullable: true, options: [
            'default' => null,
        ])]
        private ?string $resourceUuid = null,
        /**
         * @var mixed[]|null
         */
        #[ORM\Column(name: 'payload', type: Types::JSON, nullable: true, options: [
            'default' => null,
        ])]
        private ?array $payload = null,
    ) {
        $this->uuid = Uuid::v7()->toRfc4122();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getOccurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }

    public function getActorUuid(): ?string
    {
        return $this->actorUuid;
    }

    public function getResourceUuid(): ?string
    {
        return $this->resourceUuid;
    }

    /**
     * @return mixed[]|null
     */
    public function getPayload(): ?array
    {
        return $this->payload;
    }
}
