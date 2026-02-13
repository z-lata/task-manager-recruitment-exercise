<?php

declare(strict_types=1);

namespace App\Infrastructure\Users\Persistence\Doctrine\Factory;

use App\Application\Users\DTO\Model\AddressDTO as InternalAddressDTO;
use App\Application\Users\DTO\Model\GeoDTO as InternalGeoDTO;
use App\Infrastructure\Users\Persistence\Doctrine\Contract\Factory\AddressFactoryInterface;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\Address;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\ValueObject\Geo;
use Override;

final readonly class AddressFactory implements AddressFactoryInterface
{
    #[Override]
    public function createAddress(
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
    public function createAddressFromInternalDTO(InternalAddressDTO $addressDTO): Address
    {
        return $this->createAddress(
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

    #[Override]
    public function createInternalAddressDTOFromEntity(Address $address): InternalAddressDTO
    {
        $geo = $address->getGeo();
        $geoDTO = new InternalGeoDTO(lat: $geo->getLat(), lng: $geo->getLng());

        return new InternalAddressDTO(
            street: $address->getStreet(),
            suite: $address->getSuite(),
            city: $address->getCity(),
            zipcode: $address->getZipcode(),
            geo: $geoDTO,
            uuid: $address->getUuid(),
        );
    }
}
