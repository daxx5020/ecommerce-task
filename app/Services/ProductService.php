<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Events\ProductChanged;

class ProductService
{
    public function __construct(
        protected ProductRepository $productRepository
    ) {}

    public function createProduct(array $data)
    {
        $data['in_stock'] = $data['quantity'] > 0;

        $product = $this->productRepository->create($data);

        event(new ProductChanged(
            $product->id,
            'created',
            null,
            $product->toArray()
        ));

        return $product;

    }

    public function listProducts(?string $sort)
    {
        return $this->productRepository->listAvailable($sort);
    }

    public function updateProduct(int $id, array $data)
    {
        $product = $this->productRepository->findById($id);

        $oldData = $product->toArray();

        // If quantity is updated, adjust in_stock
        if (array_key_exists('quantity', $data)) {
            $data['in_stock'] = $data['quantity'] > 0;
        }

        $product->update($data);

        event(new ProductChanged(
            $product->id,
            'updated',
            $oldData,
            $product->toArray()
        ));

        return $product;
    }


}
