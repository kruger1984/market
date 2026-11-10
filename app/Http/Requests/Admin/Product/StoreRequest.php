<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product.title' => 'required|string|max:255',
            'product.sku' => 'required|string|max:255|unique:products,sku',
            'product.description' => 'required|string',
            'product.content' => 'required|string',
            'product.price' => 'required|numeric',
            'product.old_price' => 'nullable|numeric',
            'product.qty' => 'required|integer',
            'product.category_id' => 'required|integer|exists:categories,id',
            'product.product_group_id' => 'required|integer|exists:product_groups,id',
            'images' => 'nullable|array',
            'images.*' => 'required|file',
            'params' => 'nullable|array',
            'params.*.id' => 'required|integer|exists:params,id',
            'params.*.value' => 'required|string',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'product.title' => 'title',
            'product.sku' => 'SKU',
            'product.description' => 'description',
            'product.content' => 'content',
            'product.price' => 'price',
            'product.old_price' => 'old price',
            'product.qty' => 'quantity',
            'product.category_id' => 'category',
            'product.product_group_id' => 'product group',

            'params.*.id' => 'parameter',
            'params.*.value' => 'parameter value',
            'images.*' => 'image',
        ];
    }

    protected function passedValidation(): void
    {
        $validated = $this->validated();

        $this->merge([
            'product' => $validated['product'],
            'params' => $validated['params'] ?? [],
            'images' => $this->images ?? [],
        ]);
    }
}
