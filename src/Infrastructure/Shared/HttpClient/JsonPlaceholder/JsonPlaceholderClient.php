<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\HttpClient\JsonPlaceholder;

use App\Infrastructure\Shared\HttpClient\JsonPlaceholder\Contract\JsonPlaceholderClientInterface;
use App\Infrastructure\Shared\HttpClient\JsonPlaceholder\DTO\Model\UserDTO;
use Override;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

final readonly class JsonPlaceholderClient implements JsonPlaceholderClientInterface
{
    public function __construct(
        private HttpClientInterface $jsonPlaceholderHttpClient,
        private SerializerInterface $serializer,
        private LoggerInterface $logger,
    ) {
    }

    #[Override]
    public function fetchUsers(): array
    {
        try {
            $response = $this->jsonPlaceholderHttpClient->request(method: Request::METHOD_GET, url: 'users');

            return $this->serializer->deserialize(
                $response->getContent(),
                UserDTO::class . '[]',
                JsonEncoder::FORMAT,
            );
        } catch (Throwable $throwable) {
            $this->logger->error('Failed to fetch users: ' . $throwable->getMessage());

            return [];
        }
    }
}
