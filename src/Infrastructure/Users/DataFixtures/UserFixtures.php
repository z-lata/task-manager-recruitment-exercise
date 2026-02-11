<?php

declare(strict_types=1);

namespace App\Infrastructure\Users\DataFixtures;

use App\Domain\Users\Contract\Factory\UserFactoryInterface;
use App\Domain\Users\Contract\Repository\UserRepositoryInterface;
use App\Infrastructure\Shared\HttpClient\JsonPlaceholder\Contract\JsonPlaceholderClientInterface;
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

        foreach ($fakeUsers as $fakeUser) {
            $plainPassword = 'Admin1234#';
            $user = $this->userFactory->createFromDTO($fakeUser, $plainPassword);
            $this->userRepository->save($user);
        }
    }
}
