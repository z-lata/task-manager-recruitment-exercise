<?php

declare(strict_types=1);

namespace App\Domain\Users;

use App\Application\Users\DTO\Model\UserDTO;
use App\Domain\Users\Contract\Service\CreateUserServiceInterface;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\User;
use App\Infrastructure\Users\Persistence\Store\UsersStore;

final readonly class UsersFacade
{
    public function __construct(
        private CreateUserServiceInterface $createUserService,
        private UsersStore $usersStore,
    ) {
    }

    public function createUser(UserDTO $userDTO): void
    {
        $this->createUserService->createUser($userDTO);
    }

    public function fetchCurrentUser(): User
    {
        return $this->usersStore->fetchCurrentUser();
    }

    public function fetchCurrentUserWithDetails(): UserDTO
    {
        return $this->usersStore->fetchCurrentUserWithDetails();
    }

    /**
     * @return UserDTO[]
     */
    public function fetchUsersWithDetails(): array
    {
        return $this->usersStore->fetchUsersWithDetails();
    }
}
