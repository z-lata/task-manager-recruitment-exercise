<?php

declare(strict_types=1);

namespace App\Infrastructure\Users\Persistence\Doctrine\Entity;

use App\Infrastructure\Users\Persistence\Doctrine\Entity\ValueObject\Geo;
use App\Infrastructure\Users\Persistence\Doctrine\Repository\AddressRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
#[ORM\Table(name: 'address', schema: 'users')]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'id', type: Types::INTEGER, unique: true, nullable: false, options: [
        'unsigned' => true,
    ])]
    private int $id;

    #[ORM\Column(name: 'uuid', type: Types::GUID, unique: true, nullable: false)]
    private string $uuid;

    public function __construct(
        #[ORM\Column(name: 'street', type: Types::STRING, nullable: false)]
        private string $street,
        #[ORM\Column(name: 'suite', type: Types::STRING, nullable: false)]
        private string $suite,
        #[ORM\Column(name: 'city', type: Types::STRING, nullable: false)]
        private string $city,
        #[ORM\Column(name: 'zipcode', type: Types::STRING, nullable: false)]
        private string $zipcode,
        #[ORM\Embedded(class: Geo::class)]
        private Geo $geo,
    ) {
        $this->uuid = Uuid::v7()->toRfc4122();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
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

    public function getGeo(): Geo
    {
        return $this->geo;
    }
}
