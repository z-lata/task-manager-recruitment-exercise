<?php

declare(strict_types=1);

namespace App\Application\Users\DTO\Request;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Application\Users\DTO\Model\UserDTO;
use App\Application\Users\State\Processor\CreateUserProcessor;
use Symfony\Component\HttpFoundation\Response;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/api/users',
            formats: ['json'],
            status: Response::HTTP_CREATED,
            openapi: new Operation(tags: ['User'], summary: 'Register a user.', description: 'Register a user.'),
            input: UserDTO::class,
            output: false,
            processor: CreateUserProcessor::class,
        ),
    ],
)]
final readonly class CreateUserRequest
{
}
