<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function updateLastLogin(User $user): void
    {
        $user->update([
            'last_login_at' => now(),
        ]);
    }
}
