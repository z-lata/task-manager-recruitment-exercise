<?php

declare(strict_types=1);

namespace App\Application\Tasks\DTO\Response;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\OpenApi\Model\Operation;
use App\Application\Tasks\State\Provider\RetrieveUserTasksProvider;
use Symfony\Component\HttpFoundation\Response;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/api/tasks/me',
            formats: ['json'],
            status: Response::HTTP_OK,
            openapi: new Operation(
                tags: ['Task'],
                summary: 'Retrieve tasks assigned to an authenticated user.',
                description: 'Retrieve tasks assigned to an authenticated user.',
            ),
            provider: RetrieveUserTasksProvider::class,
        ),
    ],
)]
final readonly class RetrieveUserTasksResponse
{
}
