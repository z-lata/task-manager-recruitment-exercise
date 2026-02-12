<?php

declare(strict_types=1);

namespace App\Infrastructure\Users\Persistence\Doctrine\Repository;

use App\Infrastructure\Users\Persistence\Doctrine\Contract\Repository\AddressRepositoryInterface;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\Address;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Address>
 */
final class AddressRepository extends ServiceEntityRepository implements AddressRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }
}
