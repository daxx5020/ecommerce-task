<?php

namespace App\Services\Admin;

use App\Repositories\UserRepository;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    public function listUsers(array $filters)
    {
        $query = $this->userRepository->getUsers($filters);

        return [
            'users' => $query->paginate($filters['per_page'] ?? 10),
            'summary' => $this->userRepository->summaryCounts($query),
        ];
    }

    public function getUserById(int $id)
    {
        return $this->userRepository->findById($id);
    }

    public function updateUserStatus(int $id, bool $status)
    {
        return $this->userRepository->updateStatus($id, $status);
    }


}
