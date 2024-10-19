<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/orders",
     *     summary="Get a list of orders",
     *     tags={"Orders"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function index(): JsonResponse
    {
        $orders = Order::all();
        return response()->json([
            'success' => true,
            'message' => 'Orders retrieved successfully',
            'data' => $orders,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/orders",
     *     summary="Create a new order",
     *     tags={"Orders"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreOrderRequest")
     *     ),
     *     @OA\Response(response=201, description="Order created successfully"),
     *     @OA\Response(response=400, description="Invalid request"),
     *     @OA\Response(response=404, description="Product not found")
     * )
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $product = Product::find($request->product_id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        if ($product->quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock for the specified quantity',
            ], 400);
        }

        $totalPrice = $product->price * $request->quantity;

        DB::transaction(function () use ($product, $request, $totalPrice) {
            $product->quantity -= $request->quantity;
            $product->save();

            $order = Order::create([
                'user_id' => $request->user()->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'total_price' => $totalPrice,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => [
                    'order' => $order,
                    'product' => $product,
                ],
            ], 201);
        });
    }


    /**
     * @OA\Get(
     *     path="/api/orders/{id}",
     *     summary="Get a specific order",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the order",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Order retrieved successfully"),
     *     @OA\Response(response=404, description="Order not found")
     * )
     */
    public function show(string $id): JsonResponse
    {
        try {
            $order = Order::with('product', 'user')->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Order retrieved successfully',
                'data' => $order,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }
    }


    /**
     * @OA\Put(
     *     path="/api/orders/{id}",
     *     summary="Update a specific order",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the order",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateOrderRequest")
     *     ),
     *     @OA\Response(response=200, description="Order updated successfully"),
     *     @OA\Response(response=404, description="Order not found")
     * )
     */
    public function update(UpdateOrderRequest $request, string $id): JsonResponse
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        $product = Product::find($request->product_id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }


        $differenceInQuantity = $request->quantity - $order->quantity;
        if ($differenceInQuantity > 0 && $product->quantity < $differenceInQuantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock for the updated quantity',
            ], 400);
        }

        DB::transaction(function () use ($order, $request, $product, $differenceInQuantity) {
            $product->quantity -= $differenceInQuantity;
            $product->save();

            $totalPrice = $product->price * $request->quantity;

            $validatedData = $request->validated();
            $order->update([
                'product_id' => $validatedData['product_id'],
                'quantity' => $validatedData['quantity'],
                'total_price' => $totalPrice,
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully',
            'data' => $order,
        ], 200);
    }


    /**
     * @OA\Delete(
     *     path="/api/orders/{id}",
     *     summary="Delete a specific order",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the order",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Order deleted successfully"),
     *     @OA\Response(response=404, description="Order not found")
     * )
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();

            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }
    }
}
