<?php

declare(strict_types=1);

namespace App\Infrastructure\Users\DataFixtures;

use App\Infrastructure\Shared\HttpClient\JsonPlaceholder\Contract\JsonPlaceholderClientInterface;
use App\Infrastructure\Users\Persistence\Doctrine\Contract\Factory\AddressFactoryInterface;
use App\Infrastructure\Users\Persistence\Doctrine\Contract\Factory\CompanyFactoryInterface;
use App\Infrastructure\Users\Persistence\Doctrine\Contract\Factory\UserFactoryInterface;
use App\Infrastructure\Users\Persistence\Doctrine\Contract\Repository\UserRepositoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Override;

final class UserFixtures extends Fixture
{
    public function __construct(
        private readonly JsonPlaceholderClientInterface $jsonPlaceholderClient,
        private readonly UserFactoryInterface $userFactory,
        private readonly AddressFactoryInterface $addressFactory,
        private readonly CompanyFactoryInterface $companyFactory,
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    #[Override]
    public function load(ObjectManager $manager): void
    {
        $this->loadFakeUsersFromExternalApi();
        $this->loadStandardUser();
        $this->loadAdminUser();
    }

    private function loadFakeUsersFromExternalApi(): void
    {
        $fakeUsers = $this->jsonPlaceholderClient->fetchUsers();

        if ([] === $fakeUsers) {
            return;
        }

        $plainPassword = 'Admin3579!';
        $roles = ['ROLE_USER'];

        foreach ($fakeUsers as $fakeUser) {
            $user = $this->userFactory->createUserFromExternalDTO($fakeUser, $plainPassword, $roles);
            $this->userRepository->saveUser($user);
        }
    }

    private function loadStandardUser(): void
    {
        $address = $this->addressFactory->createAddress(
            street: 'ul. Borowska 213',
            suite: 'Gabinet 14',
            city: 'Wrocław',
            zipcode: '50-556',
            lat: '51.0872',
            lng: '17.0361',
        );
        $company = $this->companyFactory->createCompany(
            name: 'MediScan Solutions Sp. z o.o.',
            catchPhrase: 'Precyzyjna diagnostyka wspierana przez AI',
            bs: 'telemedicine-platforms hl7-integration medical-data-security',
        );
        $user = $this->userFactory->createUser(
            name: 'Janusz Kwiatkowski',
            username: 'j.kwiatkowski',
            plainPassword: 'Admin3579!',
            email: 'j.kwiatkowski@mediscan.pl',
            phone: '+48 123456789',
            website: 'https://mediscan.pl',
            address: $address,
            company: $company,
            roles: ['ROLE_USER'],
        );
        $this->userRepository->saveUser($user);
    }

    private function loadAdminUser(): void
    {
        $address = $this->addressFactory->createAddress(
            street: 'Aleje Jerozolimskie 100',
            suite: 'Apt. 25',
            city: 'Warszawa',
            zipcode: '00-001',
            lat: '52.2297',
            lng: '21.0122',
        );
        $company = $this->companyFactory->createCompany(
            name: 'TechSolutions Sp. z o.o.',
            catchPhrase: 'Innowacyjne podejście do zarządzania zadaniami',
            bs: 'cloud computing task-management enterprise',
        );
        $user = $this->userFactory->createUser(
            name: 'Jan Kowalski',
            username: 'admin',
            plainPassword: 'Admin3579!',
            email: 'admin@techsolutions.pl',
            phone: '+48 123456789',
            website: 'https://techsolutions.pl',
            address: $address,
            company: $company,
            roles: ['ROLE_USER', 'ROLE_ADMIN'],
        );
        $this->userRepository->saveUser($user);
    }
}
