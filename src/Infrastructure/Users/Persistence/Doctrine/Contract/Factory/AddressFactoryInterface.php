<?php

declare(strict_types=1);

namespace App\Infrastructure\Users\Persistence\Doctrine\Contract\Factory;

use App\Application\Users\DTO\Model\AddressDTO as InternalAddressDTO;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\Address;

interface AddressFactoryInterface
{
    public function createFromInternalDTO(InternalAddressDTO $addressDTO): Address;
}
