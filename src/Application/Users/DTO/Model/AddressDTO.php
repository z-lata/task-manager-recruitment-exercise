<?php

declare(strict_types=1);

namespace App\Application\Users\DTO\Model;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class AddressDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        private string $street,
        #[Assert\NotBlank]
        #[Assert\Length(max: 30)]
        private string $suite,
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        private string $city,
        #[Assert\NotBlank]
        #[Assert\Length(max: 30)]
        private string $zipcode,
        #[Assert\Valid]
        private GeoDTO $geo,
        #[Assert\NotBlank(allowNull: true)]
        #[Assert\Uuid(strict: true)]
        private ?string $uuid = null,
    ) {
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
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

    public function getGeo(): GeoDTO
    {
        return $this->geo;
    }
}
