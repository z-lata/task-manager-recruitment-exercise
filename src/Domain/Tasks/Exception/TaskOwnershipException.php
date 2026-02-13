<?php

declare(strict_types=1);

namespace App\Domain\Tasks\Exception;

final class TaskOwnershipException extends AbstractTaskException
{
    public function __construct()
    {
        parent::__construct('User does not own this task.');
    }
}
