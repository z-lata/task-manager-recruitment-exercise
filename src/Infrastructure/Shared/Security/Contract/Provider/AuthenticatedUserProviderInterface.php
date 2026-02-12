<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Security\Contract\Provider;

use App\Infrastructure\Users\Persistence\Doctrine\Entity\User;

interface AuthenticatedUserProviderInterface
{
    public function getCurrentUser(): User;
}
