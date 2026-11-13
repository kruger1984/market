<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ParamProduct;
use App\Models\Product;

class ParamProductService
{
    public static function replicateBatch(Product $product, Product $cloneProduct): void
    {
        foreach ($product->paramProducts as $paramProduct) {
            $cloneParamProduct = $paramProduct->replicate();
            $cloneParamProduct->product_id = $cloneProduct->id;
            $cloneParamProduct->push();
        }
    }

    /**
     * @return list<array{title: string|null, data: array<int, mixed>}>
     */
    public static function getGroupedByParamArray(Product $product): array
    {
        $paramProducts = ParamProduct::groupedByParams($product)->get()
            ->groupBy('param_id')->map(function ($paramProductItem) {
                return [
                    'title' => $paramProductItem->first()->title,
                    'data' => $paramProductItem->toArray(),
                ];
            });

        return array_values($paramProducts->toArray());
    }
}
