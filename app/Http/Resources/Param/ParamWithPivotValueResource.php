<?php

declare(strict_types=1);

namespace App\Http\Resources\Param;

use App\Models\Param;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Param
 */
class ParamWithPivotValueResource extends JsonResource
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
            'value' => $this->getOriginal('pivot_value'),
        ];
    }
}
