<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * @OA\Schema(
     *     schema="UpdateOrderRequest",
     *     required={"product_id", "quantity"},
     *     @OA\Property(property="product_id", type="integer"),
     *     @OA\Property(property="quantity", type="integer"),
     * )
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ];
    }
}
