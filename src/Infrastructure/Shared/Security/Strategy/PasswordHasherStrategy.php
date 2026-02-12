<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Security\Strategy;

use App\Infrastructure\Shared\Security\Contract\Strategy\PasswordHasherStrategyInterface;
use Override;
use SensitiveParameter;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

final readonly class PasswordHasherStrategy implements PasswordHasherStrategyInterface
{
    private PasswordHasherInterface $passwordHasher;

    public function __construct(#[Autowire(env: 'PASSWORD_HASHER')] string $passwordHasher)
    {
        $factory = new PasswordHasherFactory([
            'bcrypt' => [
                'algorithm' => 'bcrypt',
                'cost' => 12,
            ],
        ]);
        $this->passwordHasher = $factory->getPasswordHasher($passwordHasher);
    }

    #[Override]
    public function hash(#[SensitiveParameter] string $plainPassword): string
    {
        return $this->passwordHasher->hash($plainPassword);
    }

    #[Override]
    public function verify(string $hashedPassword, #[SensitiveParameter] string $plainPassword): bool
    {
        return $this->passwordHasher->verify($hashedPassword, $plainPassword);
    }
}
