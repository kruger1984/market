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
     * @param  Product  $product
     * @return Builder<ParamProduct>
     */
    public function scopeGroupedByParams(Builder $builder, Product $product): Builder
    {
        return self::whereHas('param', function ($b) {
            return $b->where('is_show_in_card', true);
        })->whereIn('product_id', $product->siblingProducts->pluck('id'))->with('param');
    }
}
