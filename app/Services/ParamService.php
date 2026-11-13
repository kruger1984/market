<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Category;
use App\Models\Param;
use Illuminate\Support\Collection;

class ParamService
{
    /**
     * @param  array<string, mixed>  $data
     */
    public static function store(array $data): Param
    {
        return Param::create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function update(Param $param, array $data): Param
    {
        $param->update($data);

        return $param->fresh();
    }

    /**
     * @param  Collection<int, Category>  $categoryChildren
     *
     * @return Collection<int, Param>
     */
    public static function indexByCategories(Collection $categoryChildren): Collection
    {
        $arr = [];
        foreach ($categoryChildren->pluck('paramProducts') as $paramProducts) {
            $arr = array_merge($arr, $paramProducts->toArray());
        }
        $arr = collect($arr);

        $params = Param::whereIn('id', $arr->pluck('param_id')->unique())->get();
        $arr = $arr->groupBy('param_id');

        foreach ($params as $param) {
            $param->param_values = $arr[$param->id]->unique('value')->sortBy('value')->pluck('value')->toArray();
        }

        return $params;
    }
}
