<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Collection;

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

    /**
     * @return Collection<int, Category>
     */
    public static function getCategoryChildren(Category $category): Collection
    {
        $collection = Category::hydrate([]);
        $categoryChildren = $category->children;

        foreach ($categoryChildren as $categoryChild) {
            $collection = $collection->merge(self::getCategoryChildren($categoryChild));
        }
        $collection->push($category);

        return $collection;
    }

    /**
     * @return Collection<int, Category>
     */
    public static function getCategoryParents(Category $category): Collection
    {
        $collection = Category::hydrate([]);
        if ($category->parent_id) {
            $parentCategory = $category->parent;
            $collection->push($parentCategory);
            $collection = $collection->merge(self::getCategoryParents($parentCategory));
        }

        return $collection->reverse();
    }
}
