<?php

declare(strict_types=1);

namespace App\Infrastructure\Users\Persistence\Doctrine\Contract\Repository;

use App\Infrastructure\Users\Persistence\Doctrine\Entity\User;

interface UserRepositoryInterface
{
    public function saveUser(User $user): void;

    public function findUserByUsername(string $username): ?User;

    public function findUserByEmail(string $email): ?User;

    /**
     * @return User[]
     */
    public function findUsers(): array;
}
