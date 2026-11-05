<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ProductParent;

class ProductParentService
{
    /**
     * @param  array<string, mixed>  $data
     */
    public static function store(array $data): ProductParent
    {
        return ProductParent::create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function update(ProductParent $productParent, array $data): ProductParent
    {
        $productParent->update($data);

        return $productParent->fresh();
    }
}
