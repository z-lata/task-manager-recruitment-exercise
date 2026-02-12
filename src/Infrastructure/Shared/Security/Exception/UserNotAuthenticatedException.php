<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Security\Exception;

final class UserNotAuthenticatedException extends AbstractSecurityException
{
    public function __construct()
    {
        parent::__construct('User could not be authenticated.');
    }
}
