<?php

declare(strict_types=1);

namespace App\Infrastructure\Users\Persistence\Doctrine\Contract\Factory;

use App\Application\Users\DTO\Model\UserDTO as InternalUserDTO;
use App\Infrastructure\Shared\HttpClient\JsonPlaceholder\DTO\Model\UserDTO as ExternalUserDTO;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\Address;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\Company;
use App\Infrastructure\Users\Persistence\Doctrine\Entity\User;
use SensitiveParameter;

interface UserFactoryInterface
{
    /**
     * @param string[] $roles
     */
    public function createFromParams(
        string $name,
        string $username,
        #[SensitiveParameter]
        string $plainPassword,
        string $email,
        string $phone,
        string $website,
        Address $address,
        Company $company,
        array $roles = [],
    ): User;

    /**
     * @param string[] $roles
     */
    public function createFromExternalDTO(
        ExternalUserDTO $userDTO,
        #[SensitiveParameter]
        string $plainPassword,
        array $roles = [],
    ): User;

    public function createFromEntity(User $user): InternalUserDTO;
}
