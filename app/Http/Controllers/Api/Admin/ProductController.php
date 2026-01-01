<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\Api\BaseApiController;
use App\Services\ProductService;
use App\Models\ProductActivityLog;


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

    /**
     * @OA\Patch(
     *   path="/api/admin/products/{id}",
     *   tags={"Admin - Products"},
     *   summary="Update product details",
     *   security={{"sanctum":{}}},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="name", type="string", example="Product name"),
     *       @OA\Property(property="description", type="string"),
     *       @OA\Property(property="price", type="number", example=120),
     *       @OA\Property(property="discount", type="number", example=10),
     *       @OA\Property(property="quantity", type="integer", example=15)
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Product updated successfully"
     *   )
     * )
     */
    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name'        => 'sometimes|string',
            'description' => 'sometimes|nullable|string',
            'price'       => 'sometimes|numeric|min:0',
            'discount'    => 'sometimes|numeric|min:0',
            'quantity'    => 'sometimes|integer|min:0',
        ]);

        $product = $this->productService->updateProduct($id, $data);

        return $this->ok([
            'product_id' => $product->id,
            'name'       => $product->name,
            'price'      => $product->price,
            'quantity'   => $product->quantity,
            'in_stock'   => $product->in_stock,
        ], 'Product updated successfully');
    }



    /**
     * @OA\Get(
     *   path="/api/admin/products/{id}/logs",
     *   tags={"Admin - Products"},
     *   summary="View product activity logs",
     *   security={{"sanctum":{}}},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Product activity logs",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="logs",
     *         type="array",
     *         @OA\Items(type="object")
     *       )
     *     )
     *   )
     * )
     */

    public function logs(int $id)
    {
        return $this->ok([
            'logs' => ProductActivityLog::where('product_id', $id)
                ->latest()
                ->limit(10)
                ->get(),
        ]);
    }


}
