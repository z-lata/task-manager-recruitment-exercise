<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\HttpClient\JsonPlaceholder\DTO\Model;

use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class AddressDTO
{
    public function __construct(
        private string $street,
        private string $suite,
        private string $city,
        private string $zipcode,
        #[SerializedName(serializedName: 'geo')]
        private GeoDTO $geoDTO,
    ) {
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getSuite(): string
    {
        return $this->suite;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getZipcode(): string
    {
        return $this->zipcode;
    }

    public function getGeoDTO(): GeoDTO
    {
        return $this->geoDTO;
    }
}
