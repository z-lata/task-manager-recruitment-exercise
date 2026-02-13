<?php

declare(strict_types=1);

namespace App\Domain\Tasks\Event;

use Override;

final readonly class TaskStatusUpdatedEvent extends AbstractTaskEvent
{
    #[Override]
    public function getEventType(): string
    {
        return 'task.status_updated';
    }
}
