<?php

declare(strict_types=1);

namespace App\Application\Tasks\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Tasks\DTO\Request\ChangeTaskStatusRequest;
use App\Domain\Tasks\Exception\TaskOwnershipException;
use App\Domain\Tasks\TasksFacade;
use App\Domain\Users\UsersFacade;
use App\Infrastructure\Shared\Security\Exception\AbstractSecurityException;
use Override;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;

/**
 * @implements ProcessorInterface<ChangeTaskStatusRequest, Response>
 */
final readonly class ChangeTaskStatusProcessor implements ProcessorInterface
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
    ): Response {
        /** @var ChangeTaskStatusRequest $dto */
        $dto = $data;

        try {
            $user = $this->usersFacade->fetchCurrentUser();
        } catch (AbstractSecurityException $securityException) {
            $this->logger->error('User fetching failed.' . $securityException->getMessage());
            throw new UnauthorizedHttpException('', $securityException->getMessage(), $securityException);
        }

        try {
            $this->tasksFacade->changeTaskStatus(
                userUuid: $user->getUuid(),
                taskUuid: $dto->getTaskUuid(),
                status: $dto->getStatus(),
            );
        } catch (TaskOwnershipException $e) {
            $this->logger->error('User can not change the status of a task that is not theirs.' . $e->getMessage());
            throw new AccessDeniedHttpException($e->getMessage(), $e);
        } catch (Throwable $e) {
            $this->logger->error('Task status changing failed.' . $e->getMessage());
            throw new UnprocessableEntityHttpException($e->getMessage(), $e);
        }

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}
