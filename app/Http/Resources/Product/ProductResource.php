<?php

declare(strict_types=1);

namespace App\Http\Resources\Product;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Image\ImageResource;
use App\Http\Resources\Param\ParamWithPivotValueResource;
use App\Http\Resources\ProductGroup\ProductGroupResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Product
 */
class ProductResource extends JsonResource
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
            'sku' => $this->sku,
            'description' => $this->description,
            'parent_id' => $this->parent_id,
            'content' => $this->content,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'qty' => $this->qty,
            'category_id' => $this->category_id,
            'category' => CategoryResource::make($this->category)->resolve(),
            'product_group_id' => $this->product_group_id,
            'productGroup' => ProductGroupResource::make($this->productGroup)->resolve(),
            'images' => ImageResource::collection($this->images)->resolve(),
            'preview_image_url' => $this->preview_image_url,
            'params' => ParamWithPivotValueResource::collection($this->params)->resolve(),
            'has_children' => $this->children_count ?? $this->children()->exists(),
        ];
    }
}
