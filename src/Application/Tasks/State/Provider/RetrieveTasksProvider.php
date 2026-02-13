<?php

declare(strict_types=1);

namespace App\Application\Tasks\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Tasks\DTO\Model\TaskDTO;
use App\Domain\Tasks\TasksFacade;
use Override;
use Psr\Log\LoggerInterface;
use Throwable;

/**
 * @implements ProviderInterface<TaskDTO>
 */
final readonly class RetrieveTasksProvider implements ProviderInterface
{
    public function __construct(
        private LoggerInterface $logger,
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
            return $this->tasksFacade->fetchTasks();
        } catch (Throwable $throwable) {
            $this->logger->error('Tasks fetching failed.' . $throwable->getMessage());

            return [];
        }
    }
}
