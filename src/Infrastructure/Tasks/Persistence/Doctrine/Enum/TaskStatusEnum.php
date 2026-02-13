<?php

declare(strict_types=1);

namespace App\Infrastructure\Tasks\Persistence\Doctrine\Enum;

enum TaskStatusEnum: string
{
    case TO_DO = 'To Do';
    case IN_PROGRESS = 'In Progress';
    case DONE = 'Done';

    /**
     * @var string[]
     */
    public const array ALL = [self::TO_DO->value, self::IN_PROGRESS->value, self::DONE->value];
}
