<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * @param  array<string, mixed>  $data
     */
    public static function storeBatch(Product $product, array $data): void
    {
        foreach ($data['images'] as $image) {
            $product->images()->create([
                'path' => Storage::disk('public')->put('/images', $image),
            ]);
        }
    }

    public static function destroy(Image $image): void
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();
    }

    public static function replicateBatch(Product $product, Product $cloneProduct): void
    {
        foreach ($product->images as $image) {
            $cloneImage = $image->replicate();
            $cloneImage->product_id = $cloneProduct->id;
            $cloneImage->push();
        }
    }
}
