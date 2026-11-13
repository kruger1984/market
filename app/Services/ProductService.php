<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductService
{
    /**
     * @param  array<string, mixed>  $data
     *
     * @throws Throwable
     */
    public static function store(array $data): Product
    {
        try {
            DB::beginTransaction();
            $product = Product::create($data['product']);
            self::attachBatchParams($product, $data);
            ImageService::storeBatch($product, $data);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            abort(500, $e->getMessage());
        }

        return $product->fresh();
    }

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws Throwable
     */
    public static function update(Product $product, array $data): Product
    {
        try {
            DB::beginTransaction();
            $product->update($data['product']);
            self::syncBatchParams($product, $data);
            ImageService::storeBatch($product, $data);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            abort(500, $e->getMessage());
        }

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

    /**
     * @param  Collection<int, Category>  $categoryChildren
     * @param  array<string, mixed>  $data
     *
     * @return EloquentCollection<int, Product>
     */
    public static function indexByCategories(Collection $categoryChildren, array $data): Collection
    {
        $products = Product::byCategories($categoryChildren)->filter($data);

        return $products->distinct('parent_id')->get();
    }
}
