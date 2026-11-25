<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ParamProductFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $title
 */
class ParamProduct extends Model
{
    /** @use HasFactory<ParamProductFactory> */
    use HasFactory;

    protected $table = 'param_product';

    /**
     * @return BelongsTo<Param, $this>
     */
    public function param(): BelongsTo
    {
        return $this->belongsTo(Param::class);
    }

    /**
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @param  Builder<ParamProduct>  $builder
     * @return Builder<ParamProduct>
     */
    public function scopeGroupedByParams(Builder $builder, Product $product): Builder
    {
        $productIds = $product->parent_id
            ? $product->siblingProducts->pluck('id')
            : collect([$product->id]);

        return $builder->whereHas('param', function (Builder $b) {
            $b->where('is_show_in_cart', true);
        })->whereIn('product_id', $productIds)->with('param');
    }
}
