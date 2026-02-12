<?php

declare(strict_types=1);

namespace App\Application\Users\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Users\DTO\Model\UserDTO;
use App\Domain\Users\UsersFacade;
use Override;
use Psr\Log\LoggerInterface;
use Throwable;

/**
 * @implements ProviderInterface<UserDTO>
 */
class RetrieveUsersProvider implements ProviderInterface
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly UsersFacade $usersFacade,
    ) {
    }

    /**
     * @return UserDTO[]
     */
    #[Override]
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        try {
            return $this->usersFacade->fetchUsersWithDetails();
        } catch (Throwable $throwable) {
            $this->logger->error('Users fetching failed.' . $throwable->getMessage());

            return [];
        }
    }
}
