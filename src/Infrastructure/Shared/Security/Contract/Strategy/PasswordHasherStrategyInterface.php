<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Security\Contract\Strategy;

use SensitiveParameter;

interface PasswordHasherStrategyInterface
{
    public function hash(#[SensitiveParameter] string $plainPassword): string;

    public function verify(string $hashedPassword, #[SensitiveParameter] string $plainPassword): bool;
}
