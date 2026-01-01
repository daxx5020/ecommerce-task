<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * User login
     */
    public function login(string $email, string $password): array
    {
        $user = $this->userRepository->findByEmail($email);

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials provided.'],
            ]);
        }

        if (! $user->status) {
            throw ValidationException::withMessages([
                'account' => ['Your account is inactive.'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;
        $this->userRepository->updateLastLogin($user);

        return [
            'token' => $token,
            'user'  => $user->load('roles'),
        ];
    }

    /**
     * User registration (PUBLIC)
     */
    public function register(array $data): array
    {
        // Prevent duplicate emails
        if ($this->userRepository->findByEmail($data['email'])) {
            throw ValidationException::withMessages([
                'email' => ['Email already exists.'],
            ]);
        }

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'status'   => true,
        ]);

        // Assign USER role automatically
        $userRole = Role::where('name', 'user')->first();
        $user->roles()->attach($userRole);

        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'token' => $token,
            'user'  => $user->load('roles'),
        ];
    }
}
