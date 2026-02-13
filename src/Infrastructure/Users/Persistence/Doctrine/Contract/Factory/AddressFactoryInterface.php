<?php

declare(strict_types=1);

namespace App\Infrastructure\Users\Persistence\Doctrine\Contract\Factory;

use App\Application\Users\DTO\Model\AddressDTO as InternalAddressDTO;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\Address;

interface AddressFactoryInterface
{
    public function createAddress(
        string $street,
        string $suite,
        string $city,
        string $zipcode,
        string $lat,
        string $lng,
    ): Address;

    public function createAddressFromInternalDTO(InternalAddressDTO $addressDTO): Address;

    public function createInternalAddressDTOFromEntity(Address $address): InternalAddressDTO;
}
