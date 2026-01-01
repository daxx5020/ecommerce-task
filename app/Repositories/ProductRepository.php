<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function listAvailable(?string $sort = null): Collection
    {
        $query = Product::where('is_active', true)
            ->where('in_stock', true);

        if ($sort === 'discount') {
            $query->orderBy('discount', 'desc');
        } else {
            $query->latest();
        }

        return $query->get(['id', 'name', 'price', 'discount', 'quantity']);
    }

    public function findById(int $id): Product
    {
        return Product::findOrFail($id);
    }
}
