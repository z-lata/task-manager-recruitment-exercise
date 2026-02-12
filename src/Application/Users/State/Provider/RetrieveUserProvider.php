<?php

declare(strict_types=1);

namespace App\Application\Users\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Users\DTO\Model\UserDTO;
use App\Domain\Users\UsersFacade;
use App\Infrastructure\Shared\Security\Exception\AbstractSecurityException;
use Override;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * @implements ProviderInterface<UserDTO>
 */
class RetrieveUserProvider implements ProviderInterface
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly UsersFacade $usersFacade,
    ) {
    }

    #[Override]
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): UserDTO
    {
        try {
            return $this->usersFacade->fetchCurrentUserWithDetails();
        } catch (AbstractSecurityException $securityException) {
            $this->logger->error('User fetching failed.' . $securityException->getMessage());
            throw new UnauthorizedHttpException('', $securityException->getMessage(), $securityException);
        }
    }
}
