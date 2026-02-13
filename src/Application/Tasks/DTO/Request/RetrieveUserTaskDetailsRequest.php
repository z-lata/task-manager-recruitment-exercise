<?php

declare(strict_types=1);

namespace App\Application\Tasks\DTO\Request;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Application\Tasks\State\Processor\RetrieveUserTaskDetailsProcessor;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/api/tasks/details',
            formats: ['json'],
            status: Response::HTTP_OK,
            openapi: new Operation(tags: [
                'Task',
            ], summary: 'Retrieve task details.', description: 'Retrieve task details with event history.'),
            processor: RetrieveUserTaskDetailsProcessor::class,
        ),
    ],
)]
final readonly class RetrieveUserTaskDetailsRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid(strict: true)]
        private string $taskUuid,
    ) {
    }

    public function getTaskUuid(): string
    {
        return $this->taskUuid;
    }
}
