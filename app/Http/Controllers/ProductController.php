<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class ProductController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Get a list of products",
     *     tags={"Products"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function index(): JsonResponse
    {
        // Paginar los productos para mejorar el rendimiento en listados grandes
        $products = Product::paginate(10); // Cambiar el número según lo necesario

        return response()->json([
            "success" => true,
            "message" => "Products retrieved successfully",
            "data" => $products
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Create a new product",
     *     tags={"Products"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreProductRequest")
     *     ),
     *     @OA\Response(response=201, description="Product created successfully"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $product = Product::create($validatedData);

        return response()->json([
            "success" => true,
            "message" => "Product created successfully",
            "data" => $product
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Get a specific product",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the product",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Product retrieved successfully"),
     *     @OA\Response(response=404, description="Product not found")
     * )
     */
    public function show(string $id): JsonResponse
    {
        try {
            $product = Product::findOrFail($id);

            return response()->json([
                "success" => true,
                "message" => "Product retrieved successfully",
                "data" => $product
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "success" => false,
                "message" => "Product not found"
            ], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     summary="Update a specific product",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the product",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateProductRequest")
     *     ),
     *     @OA\Response(response=200, description="Product updated successfully"),
     *     @OA\Response(response=404, description="Product not found")
     * )
     */
    public function update(UpdateProductRequest $request, string $id): JsonResponse
    {
        try {
            $product = Product::findOrFail($id);

            $validatedData = $request->validated();
            $product->update($validatedData);

            return response()->json([
                "success" => true,
                "message" => "Product updated successfully",
                "data" => $product
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "success" => false,
                "message" => "Product not found"
            ], 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Delete a specific product",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the product",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Product deleted successfully"),
     *     @OA\Response(response=404, description="Product not found")
     * )
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json([
                "success" => true,
                "message" => "Product deleted successfully"
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "success" => false,
                "message" => "Product not found"
            ], 404);
        }
    }
}
