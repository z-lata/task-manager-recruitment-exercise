<?php

declare(strict_types=1);

namespace App\Domain\Users\Contract\Factory;

use App\Domain\Users\Entity\User;
use App\Infrastructure\Shared\HttpClient\JsonPlaceholder\DTO\Model\UserDTO;
use SensitiveParameter;

interface UserFactoryInterface
{
    public function createFromDTO(UserDTO $userDTO, #[SensitiveParameter] string $plainPassword): User;
}
