<?php

declare(strict_types=1);

namespace App\Application\Users\DTO\Response;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\OpenApi\Model\Operation;
use App\Application\Users\State\Provider\RetrieveUsersProvider;
use Symfony\Component\HttpFoundation\Response;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/api/users',
            formats: ['json'],
            status: Response::HTTP_OK,
            openapi: new Operation(
                tags: ['User'],
                summary: 'Retrieve users.',
                description: 'Retrieve users with their details.',
            ),
            security: 'is_granted("ROLE_ADMIN")',
            securityMessage: 'Access denied. You do not have sufficient permissions to perform this action.',
            provider: RetrieveUsersProvider::class,
        ),
    ],
)]
final readonly class RetrieveUsersResponse
{
}
