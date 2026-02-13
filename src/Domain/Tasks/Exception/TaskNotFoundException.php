<?php

declare(strict_types=1);

namespace App\Domain\Tasks\Exception;

final class TaskNotFoundException extends AbstractTaskException
{
    public function __construct()
    {
        parent::__construct('Task not found.');
    }
}
