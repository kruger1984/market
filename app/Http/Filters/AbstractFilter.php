<?php

declare(strict_types=1);

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @template TModel of Model
 */
class AbstractFilter
{
    /** @var array<int, string> */
    protected array $keys = [];

    /**
     * @param  Builder<TModel>  $builder
     * @param  array<string, mixed>  $data
     * @return Builder<TModel>
     */
    public function apply(Builder $builder, array $data): Builder
    {
        foreach ($this->keys as $key) {
            if (isset($data[$key])) {
                $methodName = Str::camel($key);
                $this->$methodName($builder, $data[$key]);
            }
        }

        return $builder;
    }
}
