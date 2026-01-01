<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseApiController;
use App\Services\ProductService;

class ProductBrowseController extends BaseApiController
{

    public function __construct(
        protected ProductService $productService
    ) {}

    /**
     * @OA\Get(
     *     path="/api/products",
     *     tags={"User - Products"},
     *     summary="List available products",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="sort", in="query", example="discount"),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function index(Request $request)
    {
        $products = $this->productService->listProducts(
            $request->query('sort')
        );

        return $this->ok([
            'products' => $products,
        ]);
    }

}
