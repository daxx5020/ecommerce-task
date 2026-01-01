<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    public function __construct(
        protected ProductRepository $productRepository
    ) {}

    public function createProduct(array $data)
    {
        $data['in_stock'] = $data['quantity'] > 0;

        return $this->productRepository->create($data);
    }

    public function listProducts(?string $sort)
    {
        return $this->productRepository->listAvailable($sort);
    }
}
