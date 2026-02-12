<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Security\Provider;

use App\Infrastructure\Shared\Security\Contract\Provider\AuthenticatedUserProviderInterface;
use App\Infrastructure\Shared\Security\Exception\InvalidJWTTokenException;
use App\Infrastructure\Shared\Security\Exception\UserNotAuthenticatedException;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authenticator\Token\JWTPostAuthenticationToken;
use Override;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final readonly class AuthenticatedUserProvider implements AuthenticatedUserProviderInterface
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
    ) {
    }

    #[Override]
    public function getCurrentUser(): User
    {
        return $this->extractUserFromToken();
    }

    private function extractUserFromToken(): User
    {
        $token = $this->tokenStorage->getToken();

        if (false === $token instanceof JWTPostAuthenticationToken) {
            throw new InvalidJWTTokenException();
        }

        $user = $token->getUser();

        if (false === $user instanceof User) {
            throw new UserNotAuthenticatedException();
        }

        return $user;
    }
}
