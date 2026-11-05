<?php

declare(strict_types=1);

namespace App\Enums\Param;

enum ParamFilterTypeEnum: int
{
    case INTEGER = 1;
    case SELECT = 2;

    /**
     * @return array<int, string>
     */
    public static function names(): array
    {
        return array_map('strtolower', array_column(self::cases(), 'name'));
    }

    /**
     * @return array<int, int>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * @return array<int, array{value: int, label: string}>
     */
    public static function options(): array
    {
        return array_map(fn ($case) => [
            'value' => $case->value,
            'label' => ucfirst(mb_strtolower($case->name)),
        ], self::cases());
    }
}
