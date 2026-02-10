<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\HttpClient\JsonPlaceholder\DTO\Model;

use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class UserDTO
{
    public function __construct(
        private int $id,
        private string $name,
        private string $username,
        private string $email,
        #[SerializedName(serializedName: 'address')]
        private AddressDTO $addressDTO,
        private string $phone,
        private string $website,
        #[SerializedName(serializedName: 'company')]
        private CompanyDTO $companyDTO,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAddressDTO(): AddressDTO
    {
        return $this->addressDTO;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function getCompanyDTO(): CompanyDTO
    {
        return $this->companyDTO;
    }
}
