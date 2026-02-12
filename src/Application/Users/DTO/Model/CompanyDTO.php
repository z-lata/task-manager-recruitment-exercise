<?php

declare(strict_types=1);

namespace App\Application\Users\DTO\Model;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class CompanyDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        private string $name,
        #[Assert\NotBlank]
        private string $catchPhrase,
        #[Assert\NotBlank]
        private string $bs,
        #[Assert\NotBlank(allowNull: true)]
        #[Assert\Uuid(strict: true)]
        private ?string $uuid = null,
    ) {
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCatchPhrase(): string
    {
        return $this->catchPhrase;
    }

    public function getBs(): string
    {
        return $this->bs;
    }
}
