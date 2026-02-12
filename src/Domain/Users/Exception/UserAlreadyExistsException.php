<?php

declare(strict_types=1);

namespace App\Domain\Users\Exception;

final class UserAlreadyExistsException extends AbstractUserException
{
    public function __construct()
    {
        parent::__construct('User already exists.');
    }
}
