<?php

declare(strict_types=1);

namespace App\Infrastructure\Users\Persistence\Doctrine\Factory;

use App\Application\Users\DTO\Model\CompanyDTO as InternalCompanyDTO;
use App\Infrastructure\Users\Persistence\Doctrine\Contract\Factory\CompanyFactoryInterface;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\Company;
use Override;

final readonly class CompanyFactory implements CompanyFactoryInterface
{
    private function createFromParams(string $name, string $catchPhrase, string $bs): Company
    {
        return new Company(name: $name, catchPhrase: $catchPhrase, bs: $bs);
    }

    #[Override]
    public function createFromInternalDTO(InternalCompanyDTO $companyDTO): Company
    {
        return $this->createFromParams(
            name: $companyDTO->getName(),
            catchPhrase: $companyDTO->getCatchPhrase(),
            bs: $companyDTO->getBs(),
        );
    }
}
