<?php

declare(strict_types=1);

namespace App\Infrastructure\Users\Persistence\Doctrine\Repository;

use App\Infrastructure\Users\Persistence\Doctrine\Contract\Repository\UserRepositoryInterface;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Override;

/**
 * @extends ServiceEntityRepository<User>
 */
final class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    #[Override]
    public function saveUser(User $user): void
    {
        $this->getEntityManager()
            ->persist($user)
        ;
        $this->getEntityManager()
            ->flush()
        ;
    }

    #[Override]
    public function findUserByUsername(string $username): ?User
    {
        return $this->findOneBy([
            'username' => $username,
        ]);
    }

    #[Override]
    public function findUserByEmail(string $email): ?User
    {
        return $this->findOneBy([
            'email' => $email,
        ]);
    }

    /**
     * @return User[]
     */
    #[Override]
    public function findUsers(): array
    {
        return $this->findAll();
    }
}
