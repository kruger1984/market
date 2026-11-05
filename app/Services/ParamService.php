<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Param;

class ParamService
{
    /**
     * @param array<string, mixed> $data
     */
    public static function store(array $data): Param
    {
        return Param::create($data);
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function update(Param $param, array $data): Param
    {
        $param->update($data);

        return $param->fresh();
    }
}
