<?php

declare(strict_types=1);

namespace App\Application\Tasks\DTO\Response;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\OpenApi\Model\Operation;
use App\Application\Tasks\State\Provider\RetrieveTasksProvider;
use Symfony\Component\HttpFoundation\Response;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/api/tasks',
            formats: ['json'],
            status: Response::HTTP_OK,
            openapi: new Operation(tags: ['Task'], summary: 'Retrieve tasks.', description: 'Retrieve tasks.'),
            security: 'is_granted("ROLE_ADMIN")',
            securityMessage: 'Access denied. You do not have sufficient permissions to perform this action.',
            provider: RetrieveTasksProvider::class,
        ),
    ],
)]
final readonly class RetrieveTasksResponse
{
}
