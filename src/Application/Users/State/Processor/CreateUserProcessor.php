<?php

declare(strict_types=1);

namespace App\Application\Users\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Users\DTO\Model\UserDTO;
use App\Domain\Users\Exception\AbstractUserException;
use App\Domain\Users\UsersFacade;
use Override;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * @implements ProcessorInterface<UserDTO, Response>
 */
class CreateUserProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly UsersFacade $usersFacade,
    ) {
    }

    #[Override]
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): Response {
        /** @var UserDTO $dto */
        $dto = $data;

        try {
            $this->usersFacade->createUser($dto);
        } catch (AbstractUserException $userException) {
            $this->logger->error('User registration failed.' . $userException->getMessage());
            throw new UnprocessableEntityHttpException('User registration failed. Please try again.', $userException);
        }

        return new Response(status: Response::HTTP_CREATED);
    }
}
