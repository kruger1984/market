<?php

declare(strict_types=1);

namespace App\Http\Resources\Param;

use App\Enums\Param\ParamFilterTypeEnum;
use App\Models\Param;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Param
 */
class ParamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var ParamFilterTypeEnum $filterType */
        $filterType = $this->filter_type;

        return [
            'id' => $this->id,
            'title' => $this->title,
            'filter_type' => $filterType->value,
            'filter_type_label' => ucfirst(mb_strtolower($filterType->name)),
        ];
    }
}
