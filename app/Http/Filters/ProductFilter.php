<?php

declare(strict_types=1);

namespace App\Http\Filters;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends AbstractFilter<Product>
 */
class ProductFilter extends AbstractFilter
{
    /** @var array<int, string> */
    protected array $keys = [
        'integer',
        'checkbox',
        'select',
    ];

    /**
     * @param  Builder<Product>  $builder
     * @param  array<string, array<int|string, mixed>>  $value
     */
    protected function integer(Builder $builder, array $value): void
    {
        if (isset($value['from'])) {
            $builder->whereHas('paramProducts', function ($q) use ($value) {
                foreach ($value['from'] as $key => $v) {
                    $q->where('param_id', $key)->whereRaw('CAST(value as INT) >= ?', $v);
                }
            });
        }
        if (isset($value['to'])) {
            $builder->whereHas('paramProducts', function ($q) use ($value) {
                foreach ($value['to'] as $key => $v) {
                    $q->where('param_id', $key)->whereRaw('CAST(value as INT) <= ?', $v);
                }
            });
        }
    }

    /**
     * @param  Builder<Product>  $builder
     * @param  array<int|string, mixed>  $value
     */
    protected function select(Builder $builder, $value): void
    {
        $builder->whereHas('paramProducts', function ($q) use ($value) {
            foreach ($value as $key => $v) {
                $q->where('param_id', $key)->where('value', $v);
            }
        });
    }

    /**
     * @param  Builder<Product>  $builder
     * @param  array<int|string, array<int, mixed>>  $value
     */
    protected function checkbox(Builder $builder, array $value): void
    {
        $builder->whereHas('paramProducts', function ($q) use ($value) {
            foreach ($value as $key => $v) {
                $q->where('param_id', $key)->whereIn('value', $v);
            }
        });
    }
}
