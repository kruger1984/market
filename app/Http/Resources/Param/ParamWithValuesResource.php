<?php

declare(strict_types=1);

namespace App\Http\Resources\Param;

use App\Models\Param;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Param
 */
class ParamWithValuesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'filter_type' => $this->filter_type,
            'param_values' => $this->param_values,
            'label' => $this->label,
        ];
    }
}
