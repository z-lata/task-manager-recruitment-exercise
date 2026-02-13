<?php

declare(strict_types=1);

namespace App\Application\Tasks\DTO\Request;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Application\Tasks\State\Processor\ChangeTaskStatusProcessor;
use App\Infrastructure\Tasks\Persistence\Doctrine\Enum\TaskStatusEnum;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/api/tasks/change-status',
            formats: ['json'],
            status: Response::HTTP_NO_CONTENT,
            openapi: new Operation(
                tags: ['Task'],
                summary: 'Change task status.',
                description: 'Change task status.',
            ),
            output: false,
            processor: ChangeTaskStatusProcessor::class,
        ),
    ],
)]
final readonly class ChangeTaskStatusRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid(strict: true)]
        private string $taskUuid,
        #[Assert\NotBlank]
        #[Assert\Choice(choices: TaskStatusEnum::ALL)]
        private string $status,
    ) {
    }

    public function getTaskUuid(): string
    {
        return $this->taskUuid;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
