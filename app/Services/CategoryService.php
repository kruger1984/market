<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    /**
     * @param  array<string, mixed>  $data
     */
    public static function store(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function update(Category $category, array $data): Category
    {
        $category->update($data);

        return $category->fresh();
    }
}
