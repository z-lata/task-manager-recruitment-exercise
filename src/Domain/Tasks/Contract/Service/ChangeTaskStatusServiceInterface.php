<?php

declare(strict_types=1);

namespace App\Domain\Tasks\Contract\Service;

interface ChangeTaskStatusServiceInterface
{
    public function changeTaskStatus(string $userUuid, string $taskUuid, string $status): void;
}
