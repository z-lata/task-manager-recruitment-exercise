<?php

declare(strict_types=1);

namespace App\Application\Tasks\DTO\Model;

final readonly class TaskDTO
{
    public function __construct(
        private string $uuid,
        private string $status,
        private string $name,
        private string $description,
        private string $assignedUserUuid,
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getStatus(): string
    {
        return $this->status;
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
