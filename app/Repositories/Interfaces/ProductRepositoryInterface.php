<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function create(array $data): Product;

    public function listAvailable(?string $sort = null): Collection;

    public function findById(int $id): Product;
}
