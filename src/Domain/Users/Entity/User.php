<?php

declare(strict_types=1);

namespace App\Domain\Users\Entity;

use App\Infrastructure\Users\Persistence\Doctrine\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use LogicException;
use Override;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'user', schema: 'users')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
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
        #[ORM\Column(name: 'username', type: Types::STRING, length: 255, nullable: false)]
        private string $username,
        #[ORM\Column(name: 'email', type: Types::STRING, length: 255, unique: true, nullable: false)]
        private string $email,
        /**
         * Stored as hashed password.
         */
        #[ORM\Column(name: 'password', type: Types::STRING, nullable: false)]
        private string $password,
        #[ORM\Column(name: 'phone', type: Types::STRING, length: 30, nullable: false)]
        private string $phone,
        #[ORM\Column(name: 'website', type: Types::STRING, nullable: false)]
        private string $website,
        #[ORM\OneToOne(targetEntity: Address::class, cascade: ['persist', 'remove'])]
        #[ORM\JoinColumn(name: 'address_id', referencedColumnName: 'id', nullable: false)]
        #[ORM\JoinTable(name: 'address', schema: 'users')]
        private Address $address,
        #[ORM\ManyToOne(targetEntity: Company::class)]
        #[ORM\JoinColumn(name: 'company_id', referencedColumnName: 'id', nullable: false)]
        #[ORM\JoinTable(name: 'company', schema: 'users')]
        private Company $company,
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

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    #[Override]
    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getCompany(): Company
    {
        return $this->company;
    }

    /**
     * @return string[]
     */
    #[Override]
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    #[Override]
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
    }

    /**
     * @return non-empty-string
     */
    #[Override]
    public function getUserIdentifier(): string
    {
        if ('' === $this->email) {
            throw new LogicException('User email cannot be empty.');
        }

        return $this->email;
    }
}
