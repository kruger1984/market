<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ProductGroup;

class ProductGroupService
{
    /**
     * @param  array<string, mixed>  $data
     */
    public static function store(array $data): ProductGroup
    {
        return ProductGroup::create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function update(ProductGroup $productParent, array $data): ProductGroup
    {
        $productParent->update($data);

        return $productParent->fresh();
    }
}
