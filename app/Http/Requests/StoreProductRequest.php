<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     *     schema="StoreProductRequest",
     *     required={"name", "price", "quantity"},
     *     @OA\Property(property="name", type="string"),
     *     @OA\Property(property="price", type="number", format="float"),
     *     @OA\Property(property="quantity", type="integer"),
     * )
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer'
        ];
    }
}
