<?php

declare(strict_types=1);

namespace App\Domain\Tasks\Contract\Service;

interface CreateTaskServiceInterface
{
    public function createTask(string $userUuid, string $name, string $description): void;
}
