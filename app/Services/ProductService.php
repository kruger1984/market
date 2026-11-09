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
        $product = Product::create($data['product']);
        self::attachBatchParams($product, $data);
        ImageService::storeBatch($product, $data);

        return $product->fresh();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function update(Product $product, array $data): Product
    {
        $product->update($data['product']);
        self::syncBatchParams($product, $data);
        ImageService::storeBatch($product, $data);

        return $product->fresh();
    }

    /**
     * @param  array<string,  mixed>  $data
     */
    public static function attachBatchParams(Product $product, array $data): void
    {
        foreach ($data['params'] as $param) {
            $product->params()->attach($param['id'], [
                'value' => $param['value'],
            ]);
        }
    }

    /**
     * @param  array<string,  mixed>  $data
     */
    public static function syncBatchParams(Product $product, array $data): void
    {
        $product->params()->detach();
        self::attachBatchParams($product, $data);
    }
}
