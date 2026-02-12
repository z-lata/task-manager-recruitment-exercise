<?php

declare(strict_types=1);

namespace App\Infrastructure\Users\Persistence\Doctrine\Factory;

use App\Application\Users\DTO\Model\AddressDTO as InternalAddressDTO;
use App\Infrastructure\Users\Persistence\Doctrine\Contract\Factory\AddressFactoryInterface;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\Address;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\ValueObject\Geo;
use Override;

final readonly class AddressFactory implements AddressFactoryInterface
{
    private function createFromParams(
        string $street,
        string $suite,
        string $city,
        string $zipcode,
        string $lat,
        string $lng,
    ): Address {
        $geo = new Geo(lat: $lat, lng: $lng);

        return new Address(street: $street, suite: $suite, city: $city, zipcode: $zipcode, geo: $geo);
    }

    #[Override]
    public function createFromInternalDTO(InternalAddressDTO $addressDTO): Address
    {
        return $this->createFromParams(
            street: $addressDTO->getStreet(),
            suite: $addressDTO->getSuite(),
            city: $addressDTO->getCity(),
            zipcode: $addressDTO->getZipcode(),
            lat: $addressDTO->getGeo()
                ->getLat(),
            lng: $addressDTO->getGeo()
                ->getLng(),
        );
    }
}
