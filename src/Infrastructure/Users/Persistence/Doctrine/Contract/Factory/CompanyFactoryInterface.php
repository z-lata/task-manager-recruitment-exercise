<?php

declare(strict_types=1);

namespace App\Infrastructure\Users\Persistence\Doctrine\Contract\Factory;

use App\Application\Users\DTO\Model\CompanyDTO as InternalCompanyDTO;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\Company;

interface CompanyFactoryInterface
{
    public function createFromInternalDTO(InternalCompanyDTO $companyDTO): Company;
}
