<?php

declare(strict_types=1);

namespace App\Application\Users\DTO\Model;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class GeoDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 30)]
        private string $lat,
        #[Assert\NotBlank]
        #[Assert\Length(max: 30)]
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
