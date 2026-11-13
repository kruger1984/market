<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Param\ParamFilterTypeEnum;
use Database\Factories\ParamFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property array<int, mixed> $param_values
 */
class Param extends Model
{
    /** @use HasFactory<ParamFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'filter_type' => ParamFilterTypeEnum::class,
        ];
    }
}
