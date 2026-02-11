<?php

declare(strict_types=1);

namespace App\Domain\Users\Entity\ValueObject;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Geo
{
    public function __construct(
        #[ORM\Column(name: 'lat', type: Types::STRING, length: 30, nullable: false)]
        private string $lat,
        #[ORM\Column(name: 'lng', type: Types::STRING, length: 30, nullable: false)]
        private string $lng,
    ) {
    }

    public function getLat(): string
    {
        return $this->lat;
    }

    public function getLng(): string
    {
        return $this->lng;
    }
}
