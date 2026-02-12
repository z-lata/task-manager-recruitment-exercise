<?php

declare(strict_types=1);

namespace App\Domain\Users\Contract\Service;

use App\Application\Users\DTO\Model\UserDTO;

interface CreateUserServiceInterface
{
    public function createUser(UserDTO $userDTO): void;
}
