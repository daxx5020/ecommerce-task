<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\Api\BaseApiController;
use App\Services\ProductService;

class ProductController extends BaseApiController
{

    public function __construct(
        protected ProductService $productService
    ) {}

    /**
     * @OA\Post(
     *     path="/api/admin/products",
     *     tags={"Admin - Products"},
     *     summary="Create product",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","price","quantity"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="price", type="number", example=100),
     *             @OA\Property(property="discount", type="number", example=10),
     *             @OA\Property(property="quantity", type="integer", example=5)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Product created")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'discount'    => 'nullable|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
        ]);

        $product = $this->productService->createProduct($data);

        return $this->created([
            'id'   => $product->id,
            'name' => $product->name,
        ], 'Product created successfully');
    }

}
