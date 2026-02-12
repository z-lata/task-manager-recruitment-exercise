<?php

declare(strict_types=1);

namespace App\Infrastructure\Users\Persistence\Doctrine\Entity;

use App\Infrastructure\Users\Persistence\Doctrine\Repository\CompanyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ORM\Table(name: 'company', schema: 'users')]
class Company
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
        #[ORM\Column(name: 'name', type: Types::STRING, length: 255, nullable: false)]
        private string $name,
        #[ORM\Column(name: 'catchPhrase', type: Types::STRING, nullable: false)]
        private string $catchPhrase,
        #[ORM\Column(name: 'bs', type: Types::STRING, nullable: false)]
        private string $bs,
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
