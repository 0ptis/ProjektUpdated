<?php

/*
 * UserServiceInterface
 */

namespace App\Service;

use App\Entity\User;

/**
 * Interface for User-related services.
 */
interface UserServiceInterface
{
    /**
     * Update user's data and optionally change password.
     *
     * @param User        $user          User entity
     * @param string|null $plainPassword Optional new password
     */
    public function updateUser(User $user, ?string $plainPassword): void;
}
