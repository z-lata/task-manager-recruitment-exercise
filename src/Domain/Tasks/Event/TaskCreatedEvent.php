<?php

declare(strict_types=1);

namespace App\Domain\Tasks\Event;

use Override;

final readonly class TaskCreatedEvent extends AbstractTaskEvent
{
    #[Override]
    public function getEventType(): string
    {
        return 'task.created';
    }
}
