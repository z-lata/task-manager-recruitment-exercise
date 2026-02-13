<?php

declare(strict_types=1);

namespace App\Application\Tasks\DTO\Request;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Application\Tasks\State\Processor\CreateTaskProcessor;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/api/tasks',
            formats: ['json'],
            status: Response::HTTP_CREATED,
            openapi: new Operation(tags: ['Task'], summary: 'Create a task.', description: 'Create a task.'),
            output: false,
            processor: CreateTaskProcessor::class,
        ),
    ],
)]
final readonly class CreateTaskRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        private string $name,
        #[Assert\NotBlank]
        private string $description,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
