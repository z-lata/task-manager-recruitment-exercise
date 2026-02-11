<?php

declare(strict_types=1);

namespace App\Infrastructure\Users\Persistence\Doctrine;

use App\Domain\Users\Contract\Repository\CompanyRepositoryInterface;
use App\Domain\Users\Entity\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Company>
 */
final class CompanyRepository extends ServiceEntityRepository implements CompanyRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }
}
