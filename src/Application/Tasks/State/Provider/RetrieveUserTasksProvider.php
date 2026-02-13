<?php

declare(strict_types=1);

namespace App\Application\Tasks\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Tasks\DTO\Model\TaskDTO;
use App\Domain\Tasks\TasksFacade;
use App\Domain\Users\UsersFacade;
use App\Infrastructure\Shared\Security\Exception\AbstractSecurityException;
use Override;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

/**
 * @implements ProviderInterface<TaskDTO>
 */
final readonly class RetrieveUserTasksProvider implements ProviderInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private UsersFacade $usersFacade,
        private TasksFacade $tasksFacade,
    ) {
    }

    /**
     * @return TaskDTO[]
     */
    #[Override]
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        try {
            $user = $this->usersFacade->fetchCurrentUser();
        } catch (AbstractSecurityException $securityException) {
            $this->logger->error('User fetching failed.' . $securityException->getMessage());
            throw new UnauthorizedHttpException('', $securityException->getMessage(), $securityException);
        }

        try {
            return $this->tasksFacade->fetchTasksAssignedToUser(userUuid: $user->getUuid());
        } catch (Throwable $throwable) {
            $this->logger->error('Tasks fetching failed.' . $throwable->getMessage());

            return [];
        }
    }
}
