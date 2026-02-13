<?php

declare(strict_types=1);

namespace App\Infrastructure\Tasks\Persistence\Doctrine\Entity;

use App\Infrastructure\Tasks\Persistence\Doctrine\Enum\TaskStatusEnum;
use App\Infrastructure\Tasks\Persistence\Doctrine\Repository\TaskRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ORM\Table(name: 'task', schema: 'tasks')]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'id', type: Types::INTEGER, unique: true, nullable: false, options: [
        'unsigned' => true,
    ])]
    private int $id;

    #[ORM\Column(name: 'uuid', type: Types::GUID, unique: true, nullable: false)]
    private string $uuid;

    #[ORM\Column(name: 'status', type: Types::ENUM, nullable: false, options: [
        'default' => TaskStatusEnum::TO_DO,
    ])]
    private TaskStatusEnum $status = TaskStatusEnum::TO_DO;

    public function __construct(
        #[ORM\Column(name: 'name', type: Types::STRING, length: 255, nullable: false)]
        private string $name,
        #[ORM\Column(name: 'description', type: Types::TEXT, nullable: false)]
        private string $description,
        #[ORM\Column(name: 'assigned_user_uuid', type: Types::GUID, nullable: false)]
        private string $assignedUserUuid,
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

    public function getStatus(): TaskStatusEnum
    {
        return $this->status;
    }

    public function setStatus(TaskStatusEnum $status): void
    {
        $this->status = $status;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAssignedUserUuid(): string
    {
        return $this->assignedUserUuid;
    }
}
