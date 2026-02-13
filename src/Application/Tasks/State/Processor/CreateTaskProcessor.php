<?php

declare(strict_types=1);

namespace App\Application\Tasks\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Tasks\DTO\Request\CreateTaskRequest;
use App\Domain\Tasks\TasksFacade;
use App\Domain\Users\UsersFacade;
use App\Infrastructure\Shared\Security\Exception\AbstractSecurityException;
use Override;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;

/**
 * @implements ProcessorInterface<CreateTaskRequest, Response>
 */
final readonly class CreateTaskProcessor implements ProcessorInterface
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
        /** @var CreateTaskRequest $dto */
        $dto = $data;

        try {
            $user = $this->usersFacade->fetchCurrentUser();
        } catch (AbstractSecurityException $securityException) {
            $this->logger->error('User fetching failed.' . $securityException->getMessage());
            throw new UnauthorizedHttpException('', $securityException->getMessage(), $securityException);
        }

        try {
            $this->tasksFacade->createTask(
                userUuid: $user->getUuid(),
                name: $dto->getName(),
                description: $dto->getDescription(),
            );
        } catch (Throwable $throwable) {
            $this->logger->error('Task creating failed.' . $throwable->getMessage());
            throw new UnprocessableEntityHttpException($throwable->getMessage(), $throwable);
        }

        return new Response(status: Response::HTTP_CREATED);
    }
}
