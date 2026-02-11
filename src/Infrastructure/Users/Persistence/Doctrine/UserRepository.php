<?php

declare(strict_types=1);

namespace App\Infrastructure\Users\Persistence\Doctrine;

use App\Domain\Users\Contract\Repository\UserRepositoryInterface;
use App\Domain\Users\Entity\User;
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
    public function save(User $user): void
    {
        $this->getEntityManager()
            ->persist($user->getCompany())
        ;
        $this->getEntityManager()
            ->persist($user->getAddress())
        ;
        $this->getEntityManager()
            ->persist($user)
        ;
        $this->getEntityManager()
            ->flush()
        ;
    }
}
