<?php

declare(strict_types=1);

namespace App\Infrastructure\Users\Persistence\Doctrine\Factory;

use App\Application\Users\DTO\Model\UserDTO as InternalUserDTO;
use App\Infrastructure\Shared\HttpClient\JsonPlaceholder\DTO\Model\UserDTO as ExternalUserDTO;
use App\Infrastructure\Shared\Security\Contract\Strategy\PasswordHasherStrategyInterface;
use App\Infrastructure\Users\Persistence\Doctrine\Contract\Factory\AddressFactoryInterface;
use App\Infrastructure\Users\Persistence\Doctrine\Contract\Factory\CompanyFactoryInterface;
use App\Infrastructure\Users\Persistence\Doctrine\Contract\Factory\UserFactoryInterface;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\Address;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\Company;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\User;
use Override;
use SensitiveParameter;

final readonly class UserFactory implements UserFactoryInterface
{
    public function __construct(
        private AddressFactoryInterface $addressFactory,
        private CompanyFactoryInterface $companyFactory,
        private PasswordHasherStrategyInterface $passwordHasherStrategy,
    ) {
    }

    /**
     * @param string[] $roles
     */
    #[Override]
    public function createUser(
        string $name,
        string $username,
        #[SensitiveParameter]
        string $plainPassword,
        string $email,
        string $phone,
        string $website,
        Address $address,
        Company $company,
        array $roles = [],
    ): User {
        $hashedPassword = $this->passwordHasherStrategy->hash($plainPassword);

        $user = new User(
            name: $name,
            username: $username,
            password: $hashedPassword,
            email: $email,
            phone: $phone,
            website: $website,
            address: $address,
            company: $company,
        );
        $user->setRoles($roles);

        return $user;
    }

    /**
     * @param string[] $roles
     */
    #[Override]
    public function createUserFromExternalDTO(
        ExternalUserDTO $userDTO,
        #[SensitiveParameter]
        string $plainPassword,
        array $roles = [],
    ): User {
        $addressDTO = $userDTO->getAddressDTO();
        $geoDTO = $addressDTO->getGeoDTO();
        $address = $this->addressFactory->createAddress(
            street: $addressDTO->getStreet(),
            suite: $addressDTO->getSuite(),
            city: $addressDTO->getCity(),
            zipcode: $addressDTO->getZipcode(),
            lat: $geoDTO->getLat(),
            lng: $geoDTO->getLng(),
        );

        $companyDTO = $userDTO->getCompanyDTO();
        $company = $this->companyFactory->createCompany(
            name: $companyDTO->getName(),
            catchPhrase: $companyDTO->getCatchPhrase(),
            bs: $companyDTO->getBs(),
        );

        return $this->createUser(
            name: $userDTO->getName(),
            username: $userDTO->getUsername(),
            plainPassword: $plainPassword,
            email: $userDTO->getEmail(),
            phone: $userDTO->getPhone(),
            website: $userDTO->getWebsite(),
            address: $address,
            company: $company,
            roles: $roles,
        );
    }

    #[Override]
    public function createInternalUserDTOFromEntity(User $user): InternalUserDTO
    {
        $address = $user->getAddress();
        $addressDTO = $this->addressFactory->createInternalAddressDTOFromEntity($address);

        $company = $user->getCompany();
        $companyDTO = $this->companyFactory->createInternalCompanyDTOFromEntity($company);

        return new InternalUserDTO(
            name: $user->getName(),
            username: $user->getUsername(),
            password: '********',
            email: $user->getEmail(),
            phone: $user->getPhone(),
            website: $user->getWebsite(),
            address: $addressDTO,
            company: $companyDTO,
            uuid: $user->getUuid(),
        );
    }
}
