<?php

declare(strict_types=1);

namespace App\Domain\Users\Contract\Repository;

use App\Domain\Users\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;
}
