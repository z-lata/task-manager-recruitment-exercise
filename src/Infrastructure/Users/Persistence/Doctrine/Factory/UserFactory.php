<?php

declare(strict_types=1);

namespace App\Infrastructure\Users\Persistence\Doctrine\Factory;

use App\Application\Users\DTO\Model\AddressDTO as InternalAddressDTO;
use App\Application\Users\DTO\Model\CompanyDTO as InternalCompanyDTO;
use App\Application\Users\DTO\Model\GeoDTO as InternalGeoDTO;
use App\Application\Users\DTO\Model\UserDTO as InternalUserDTO;
use App\Infrastructure\Shared\HttpClient\JsonPlaceholder\DTO\Model\UserDTO as ExternalUserDTO;
use App\Infrastructure\Shared\Security\Contract\Strategy\PasswordHasherStrategyInterface;
use App\Infrastructure\Users\Persistence\Doctrine\Contract\Factory\UserFactoryInterface;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\Address;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\Company;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\User;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\ValueObject\Geo;
use Override;
use SensitiveParameter;

final readonly class UserFactory implements UserFactoryInterface
{
    public function __construct(
        private PasswordHasherStrategyInterface $passwordHasherStrategy,
    ) {
    }

    /**
     * @param string[] $roles
     */
    #[Override]
    public function createFromParams(
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
    public function createFromExternalDTO(
        ExternalUserDTO $userDTO,
        #[SensitiveParameter]
        string $plainPassword,
        array $roles = [],
    ): User {
        $addressDTO = $userDTO->getAddressDTO();
        $geoDTO = $addressDTO->getGeoDTO();
        $geo = new Geo(lat: $geoDTO->getLat(), lng: $geoDTO->getLng());
        $address = new Address(
            street: $addressDTO->getStreet(),
            suite: $addressDTO->getSuite(),
            city: $addressDTO->getCity(),
            zipcode: $addressDTO->getZipcode(),
            geo: $geo,
        );

        $companyDTO = $userDTO->getCompanyDTO();
        $company = new Company(
            name: $companyDTO->getName(),
            catchPhrase: $companyDTO->getCatchPhrase(),
            bs: $companyDTO->getBs(),
        );

        return $this->createFromParams(
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
    public function createFromEntity(User $user): InternalUserDTO
    {
        $address = $user->getAddress();
        $geo = $address->getGeo();
        $geoDTO = new InternalGeoDTO(lat: $geo->getLat(), lng: $geo->getLng());
        $addressDTO = new InternalAddressDTO(
            street: $address->getStreet(),
            suite: $address->getSuite(),
            city: $address->getCity(),
            zipcode: $address->getZipcode(),
            geo: $geoDTO,
            uuid: $address->getUuid(),
        );

        $company = $user->getCompany();
        $companyDTO = new InternalCompanyDTO(
            name: $company->getName(),
            catchPhrase: $company->getCatchPhrase(),
            bs: $company->getBs(),
            uuid: $company->getUuid(),
        );

        return new InternalUserDTO(
            name: $user->getName(),
            username: $user->getUsername(),
            password: '',
            email: $user->getEmail(),
            phone: $user->getPhone(),
            website: $user->getWebsite(),
            address: $addressDTO,
            company: $companyDTO,
            uuid: $user->getUuid(),
        );
    }
}
