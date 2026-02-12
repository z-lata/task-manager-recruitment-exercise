<?php

declare(strict_types=1);

namespace App\Application\Users\DTO\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Email;

final readonly class UserDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        private string $name,
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        private string $username,
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        #[Assert\NotCompromisedPassword]
        #[Assert\PasswordStrength]
        private string $password,
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        #[Email(mode: Email::VALIDATION_MODE_STRICT)]
        private string $email,
        #[Assert\NotBlank]
        #[Assert\Length(max: 30)]
        private string $phone,
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        #[Assert\Url(relativeProtocol: true)]
        private string $website,
        #[Assert\Valid]
        private AddressDTO $address,
        #[Assert\Valid]
        private CompanyDTO $company,
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

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function getAddress(): AddressDTO
    {
        return $this->address;
    }

    public function getCompany(): CompanyDTO
    {
        return $this->company;
    }
}
