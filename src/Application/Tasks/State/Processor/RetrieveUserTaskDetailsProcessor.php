<?php

declare(strict_types=1);

namespace App\Application\Tasks\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Tasks\DTO\Model\TaskDetailsDTO;
use App\Application\Tasks\DTO\Request\RetrieveUserTaskDetailsRequest;
use App\Domain\Tasks\Exception\TaskOwnershipException;
use App\Domain\Tasks\TasksFacade;
use App\Domain\Users\UsersFacade;
use App\Infrastructure\Shared\Security\Exception\AbstractSecurityException;
use Override;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

/**
 * @implements ProcessorInterface<RetrieveUserTaskDetailsRequest, TaskDetailsDTO>
 */
final readonly class RetrieveUserTaskDetailsProcessor implements ProcessorInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private UsersFacade $usersFacade,
        private TasksFacade $tasksFacade,
    ) {
    }

    #[Override]
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): TaskDetailsDTO {
        /** @var RetrieveUserTaskDetailsRequest $dto */
        $dto = $data;

        try {
            $user = $this->usersFacade->fetchCurrentUser();
        } catch (AbstractSecurityException $securityException) {
            $this->logger->error('User fetching failed.' . $securityException->getMessage());
            throw new UnauthorizedHttpException('', $securityException->getMessage(), $securityException);
        }

        try {
            $isAdmin = in_array('ROLE_ADMIN', $user->getRoles(), true);

            return $this->tasksFacade->fetchTaskDetailsAssignedToUser(
                taskUuid: $dto->getTaskUuid(),
                userUuid: $user->getUuid(),
                isAdmin: $isAdmin,
            );
        } catch (TaskOwnershipException $e) {
            $this->logger->error('User do not have access to task that is not theirs.' . $e->getMessage());
            throw new AccessDeniedHttpException($e->getMessage(), $e);
        } catch (Throwable $e) {
            $this->logger->error('Task details fetching failed.' . $e->getMessage());
            throw new NotFoundHttpException($e->getMessage(), $e);
        }
    }
}
