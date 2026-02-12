<?php

declare(strict_types=1);

namespace App\Application\Users\DTO\Response;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\OpenApi\Model\Operation;
use App\Application\Users\State\Provider\RetrieveUserProvider;
use Symfony\Component\HttpFoundation\Response;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/api/users/me',
            formats: ['json'],
            status: Response::HTTP_OK,
            openapi: new Operation(
                tags: ['User'],
                summary: 'Retrieve an authenticated user with their details.',
                description: 'Extract an authenticated user from JWT token and retrieve their details.',
            ),
            provider: RetrieveUserProvider::class,
        ),
    ],
)]
final readonly class RetrieveUserResponse
{
}
