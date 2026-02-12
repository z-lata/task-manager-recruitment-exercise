<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Security\Exception;

final class InvalidJWTTokenException extends AbstractSecurityException
{
    public function __construct()
    {
        parent::__construct('Invalid JWT Token.');
    }
}
