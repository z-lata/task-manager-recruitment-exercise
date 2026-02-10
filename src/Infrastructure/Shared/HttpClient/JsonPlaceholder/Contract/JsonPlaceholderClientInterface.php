<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\HttpClient\JsonPlaceholder\Contract;

use App\Infrastructure\Shared\HttpClient\JsonPlaceholder\DTO\Model\UserDTO;

interface JsonPlaceholderClientInterface
{
    /**
     * @return UserDTO[]
     */
    public function fetchUsers(): array;
}
