<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 */
trait HasFilter
{
    /**
     * @param  Builder<TModel>  $builder
     * @param  array<string, mixed>  $data
     * @return Builder<TModel>
     */
    public function scopeFilter(Builder $builder, $data): Builder
    {
        /** @var class-string<AbstractFilter<TModel>> $className */
        $className = 'App\\Http\\Filters\\'.class_basename($this).'Filter';

        return (new $className)->apply($builder, $data);
    }
}
