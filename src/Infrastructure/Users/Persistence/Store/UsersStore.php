<?php

declare(strict_types=1);

namespace App\Infrastructure\Users\Persistence\Store;

use App\Application\Users\DTO\Model\UserDTO;
use App\Infrastructure\Shared\Security\Contract\Provider\AuthenticatedUserProviderInterface;
use App\Infrastructure\Users\Persistence\Doctrine\Contract\Factory\AddressFactoryInterface;
use App\Infrastructure\Users\Persistence\Doctrine\Contract\Factory\CompanyFactoryInterface;
use App\Infrastructure\Users\Persistence\Doctrine\Contract\Factory\UserFactoryInterface;
use App\Infrastructure\Users\Persistence\Doctrine\Contract\Repository\UserRepositoryInterface;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\User;

final readonly class UsersStore
{
    public function __construct(
        private UserFactoryInterface $userFactory,
        private AddressFactoryInterface $addressFactory,
        private CompanyFactoryInterface $companyFactory,
        private AuthenticatedUserProviderInterface $authenticatedUserProvider,
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function createUser(UserDTO $userDTO): void
    {
        $roles = ['ROLE_USER'];
        $address = $this->addressFactory->createFromInternalDTO($userDTO->getAddress());
        $company = $this->companyFactory->createFromInternalDTO($userDTO->getCompany());
        $user = $this->userFactory->createFromParams(
            name: $userDTO->getName(),
            username: $userDTO->getUsername(),
            plainPassword: $userDTO->getPassword(),
            email: $userDTO->getEmail(),
            phone: $userDTO->getPhone(),
            website: $userDTO->getWebsite(),
            address: $address,
            company: $company,
            roles: $roles,
        );

        $this->userRepository->saveUser($user);
    }

    public function isUserExist(string $username, string $email): bool
    {
        if ($this->isUserExistByUsername($username)) {
            return true;
        }

        return $this->isUserExistByEmail($email);
    }

    private function isUserExistByUsername(string $username): bool
    {
        return $this->userRepository->findUserByUsername($username) instanceof User;
    }

    private function isUserExistByEmail(string $email): bool
    {
        return $this->userRepository->findUserByEmail($email) instanceof User;
    }

    public function fetchCurrentUser(): User
    {
        return $this->authenticatedUserProvider->getCurrentUser();
    }

    public function fetchCurrentUserWithDetails(): UserDTO
    {
        $user = $this->fetchCurrentUser();

        return $this->userFactory->createFromEntity($user);
    }

    /**
     * @return UserDTO[]
     */
    public function fetchUsersWithDetails(): array
    {
        $users = $this->userRepository->findUsers();

        return array_map(callback: $this->userFactory->createFromEntity(...), array: $users);
    }
}
