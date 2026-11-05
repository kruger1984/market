<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;

class ProductService
{
    /**
     * @param  array<string, mixed>  $data
     */
    public static function store(array $data): Product
    {
        return Product::create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function update(Product $product, array $data): Product
    {
        $product->update($data);

        return $product->fresh();
    }
}
