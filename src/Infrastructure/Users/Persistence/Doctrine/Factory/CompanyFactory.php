<?php

declare(strict_types=1);

namespace App\Infrastructure\Users\Persistence\Doctrine\Factory;

use App\Application\Users\DTO\Model\CompanyDTO as InternalCompanyDTO;
use App\Infrastructure\Users\Persistence\Doctrine\Contract\Factory\CompanyFactoryInterface;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\Company;
use Override;

final readonly class CompanyFactory implements CompanyFactoryInterface
{
    #[Override]
    public function createCompany(string $name, string $catchPhrase, string $bs): Company
    {
        return new Company(name: $name, catchPhrase: $catchPhrase, bs: $bs);
    }

    #[Override]
    public function createCompanyFromInternalDTO(InternalCompanyDTO $companyDTO): Company
    {
        return $this->createCompany(
            name: $companyDTO->getName(),
            catchPhrase: $companyDTO->getCatchPhrase(),
            bs: $companyDTO->getBs(),
        );
    }

    #[Override]
    public function createInternalCompanyDTOFromEntity(Company $company): InternalCompanyDTO
    {
        return new InternalCompanyDTO(
            name: $company->getName(),
            catchPhrase: $company->getCatchPhrase(),
            bs: $company->getBs(),
            uuid: $company->getUuid(),
        );
    }
}
