<?php

declare(strict_types=1);

namespace App\Infrastructure\Users\DataFixtures;

use App\Infrastructure\Shared\HttpClient\JsonPlaceholder\Contract\JsonPlaceholderClientInterface;
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
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    #[Override]
    public function load(ObjectManager $manager): void
    {
        $fakeUsers = $this->jsonPlaceholderClient->fetchUsers();

        if ([] === $fakeUsers) {
            return;
        }

        $plainPassword = 'Admin3579!';
        $roles = ['ROLE_USER'];

        foreach ($fakeUsers as $fakeUser) {
            $user = $this->userFactory->createFromExternalDTO($fakeUser, $plainPassword, $roles);
            $this->userRepository->saveUser($user);
        }
    }
}
