<?php

declare(strict_types=1);

namespace App\Infrastructure\Tasks\Messaging\Contract\EventDispatcher\Publisher;

use App\Domain\Tasks\Event\AbstractTaskEvent;

interface TaskEventPublisherInterface
{
    public function publish(AbstractTaskEvent $event): void;
}
