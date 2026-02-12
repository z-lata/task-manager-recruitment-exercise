<?php

declare(strict_types=1);

namespace App\Domain\Users\Service;

use App\Application\Users\DTO\Model\UserDTO;
use App\Domain\Users\Contract\Service\CreateUserServiceInterface;
use App\Domain\Users\Exception\UserAlreadyExistsException;
use App\Infrastructure\Users\Persistence\Store\UsersStore;
use Override;

final readonly class CreateUserService implements CreateUserServiceInterface
{
    public function __construct(
        private UsersStore $usersStore,
    ) {
    }

    #[Override]
    public function createUser(UserDTO $userDTO): void
    {
        if ($this->usersStore->isUserExist(username: $userDTO->getUsername(), email: $userDTO->getEmail())
        ) {
            throw new UserAlreadyExistsException();
        }

        $this->usersStore->createUser($userDTO);
    }
}
