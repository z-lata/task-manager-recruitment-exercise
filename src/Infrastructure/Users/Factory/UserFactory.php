<?php

declare(strict_types=1);

namespace App\Infrastructure\Users\Factory;

use App\Domain\Users\Contract\Factory\UserFactoryInterface;
use App\Domain\Users\Contract\Strategy\PasswordHasherStrategyInterface;
use App\Domain\Users\Entity\Address;
use App\Domain\Users\Entity\Company;
use App\Domain\Users\Entity\User;
use App\Domain\Users\Entity\ValueObject\Geo;
use App\Infrastructure\Shared\HttpClient\JsonPlaceholder\DTO\Model\UserDTO;
use Override;
use SensitiveParameter;

final readonly class UserFactory implements UserFactoryInterface
{
    public function __construct(
        private PasswordHasherStrategyInterface $passwordHasherStrategy,
    ) {
    }

    #[Override]
    public function createFromDTO(UserDTO $userDTO, #[SensitiveParameter] string $plainPassword): User
    {
        $hashedPassword = $this->passwordHasherStrategy->hash($plainPassword);

        $company = new Company(
            name: $userDTO->getCompanyDTO()
                ->getName(),
            catchPhrase: $userDTO->getCompanyDTO()
                ->getCatchPhrase(),
            bs: $userDTO->getCompanyDTO()
                ->getBs(),
        );

        $address = new Address(
            street: $userDTO->getAddressDTO()
                ->getStreet(),
            suite: $userDTO->getAddressDTO()
                ->getSuite(),
            city: $userDTO->getAddressDTO()
                ->getCity(),
            zipcode: $userDTO->getAddressDTO()
                ->getZipcode(),
            geo: new Geo(
                lat: $userDTO->getAddressDTO()
                    ->getGeoDTO()
                    ->getLat(),
                lng: $userDTO->getAddressDTO()
                    ->getGeoDTO()
                    ->getLng(),
            ),
        );

        return new User(
            name: $userDTO->getName(),
            username: $userDTO->getUsername(),
            email: $userDTO->getEmail(),
            password: $hashedPassword,
            phone: $userDTO->getPhone(),
            website: $userDTO->getWebsite(),
            address: $address,
            company: $company,
        );
    }
}
