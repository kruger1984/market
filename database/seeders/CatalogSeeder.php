<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Param\ParamFilterTypeEnum;
use App\Models\Category;
use App\Models\Param;
use App\Models\Product;
use App\Models\ProductGroup;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $clothing = Category::factory()->create(['title' => 'Clothing']);

        $outerwear = Category::factory()->nested($clothing)->create(['title' => 'Outerwear']);
        $tops = Category::factory()->nested($clothing)->create(['title' => 'Tops']);
        $bottoms = Category::factory()->nested($clothing)->create(['title' => 'Bottoms']);
        $knitwear = Category::factory()->nested($clothing)->create(['title' => 'Knitwear']);

        $jackets = Category::factory()->nested($outerwear)->create(['title' => 'Jackets']);
        $coats = Category::factory()->nested($outerwear)->create(['title' => 'Coats']);
        $tShirts = Category::factory()->nested($tops)->create(['title' => 'T-Shirts']);
        $shirts = Category::factory()->nested($tops)->create(['title' => 'Shirts']);
        $jeans = Category::factory()->nested($bottoms)->create(['title' => 'Jeans']);
        $trousers = Category::factory()->nested($bottoms)->create(['title' => 'Trousers']);
        $sweaters = Category::factory()->nested($knitwear)->create(['title' => 'Sweaters']);
        $hoodies = Category::factory()->nested($knitwear)->create(['title' => 'Hoodies']);

        $color = Param::factory()->create([
            'title' => 'Color',
            'filter_type' => ParamFilterTypeEnum::cases()[0],
        ]);

        $size = Param::factory()->create([
            'title' => 'Size',
            'filter_type' => ParamFilterTypeEnum::cases()[0],
        ]);

        $material = Param::factory()->create([
            'title' => 'Material',
            'filter_type' => ParamFilterTypeEnum::cases()[0],
        ]);

        $variants = [
            [
                'category' => $jackets,
                'parent' => 'Classic Denim Jacket',
                'children' => [
                    ['title' => 'Classic Denim Jacket - Blue S', 'price' => 89, 'old_price' => 110, 'params' => [$color->id => ['value' => 'Blue'], $size->id => ['value' => 'S'], $material->id => ['value' => 'Denim']]],
                    ['title' => 'Classic Denim Jacket - Blue M', 'price' => 89, 'old_price' => 110, 'params' => [$color->id => ['value' => 'Blue'], $size->id => ['value' => 'M'], $material->id => ['value' => 'Denim']]],
                    ['title' => 'Classic Denim Jacket - Black L', 'price' => 95, 'old_price' => 120, 'params' => [$color->id => ['value' => 'Black'], $size->id => ['value' => 'L'], $material->id => ['value' => 'Denim']]],
                ],
            ],
            [
                'category' => $jackets,
                'parent' => 'Lightweight Bomber Jacket',
                'children' => [
                    ['title' => 'Lightweight Bomber Jacket - Olive M', 'price' => 110, 'old_price' => 140, 'params' => [$color->id => ['value' => 'Olive'], $size->id => ['value' => 'M'], $material->id => ['value' => 'Nylon']]],
                    ['title' => 'Lightweight Bomber Jacket - Olive L', 'price' => 110, 'old_price' => 140, 'params' => [$color->id => ['value' => 'Olive'], $size->id => ['value' => 'L'], $material->id => ['value' => 'Nylon']]],
                    ['title' => 'Lightweight Bomber Jacket - Navy XL', 'price' => 115, 'old_price' => 145, 'params' => [$color->id => ['value' => 'Navy'], $size->id => ['value' => 'XL'], $material->id => ['value' => 'Nylon']]],
                ],
            ],
            [
                'category' => $coats,
                'parent' => 'Wool Blend Overcoat',
                'children' => [
                    ['title' => 'Wool Blend Overcoat - Camel M', 'price' => 190, 'old_price' => 240, 'params' => [$color->id => ['value' => 'Camel'], $size->id => ['value' => 'M'], $material->id => ['value' => 'Wool']]],
                    ['title' => 'Wool Blend Overcoat - Camel L', 'price' => 190, 'old_price' => 240, 'params' => [$color->id => ['value' => 'Camel'], $size->id => ['value' => 'L'], $material->id => ['value' => 'Wool']]],
                    ['title' => 'Wool Blend Overcoat - Charcoal L', 'price' => 195, 'old_price' => 250, 'params' => [$color->id => ['value' => 'Charcoal'], $size->id => ['value' => 'L'], $material->id => ['value' => 'Wool']]],
                ],
            ],
            [
                'category' => $coats,
                'parent' => 'Waterproof Trench Coat',
                'children' => [
                    ['title' => 'Waterproof Trench Coat - Beige S', 'price' => 160, 'old_price' => 200, 'params' => [$color->id => ['value' => 'Beige'], $size->id => ['value' => 'S'], $material->id => ['value' => 'Cotton']]],
                    ['title' => 'Waterproof Trench Coat - Beige M', 'price' => 160, 'old_price' => 200, 'params' => [$color->id => ['value' => 'Beige'], $size->id => ['value' => 'M'], $material->id => ['value' => 'Cotton']]],
                    ['title' => 'Waterproof Trench Coat - Black M', 'price' => 165, 'old_price' => 210, 'params' => [$color->id => ['value' => 'Black'], $size->id => ['value' => 'M'], $material->id => ['value' => 'Cotton']]],
                ],
            ],
            [
                'category' => $tShirts,
                'parent' => 'Essential Cotton T-Shirt',
                'children' => [
                    ['title' => 'Essential Cotton T-Shirt - White S', 'price' => 25, 'old_price' => 30, 'params' => [$color->id => ['value' => 'White'], $size->id => ['value' => 'S'], $material->id => ['value' => 'Cotton']]],
                    ['title' => 'Essential Cotton T-Shirt - White M', 'price' => 25, 'old_price' => 30, 'params' => [$color->id => ['value' => 'White'], $size->id => ['value' => 'M'], $material->id => ['value' => 'Cotton']]],
                    ['title' => 'Essential Cotton T-Shirt - Black M', 'price' => 25, 'old_price' => 30, 'params' => [$color->id => ['value' => 'Black'], $size->id => ['value' => 'M'], $material->id => ['value' => 'Cotton']]],
                    ['title' => 'Essential Cotton T-Shirt - Olive L', 'price' => 27, 'old_price' => 35, 'params' => [$color->id => ['value' => 'Olive'], $size->id => ['value' => 'L'], $material->id => ['value' => 'Cotton']]],
                ],
            ],
            [
                'category' => $tShirts,
                'parent' => 'Oversized Heavyweight Tee',
                'children' => [
                    ['title' => 'Oversized Heavyweight Tee - Grey M', 'price' => 32, 'old_price' => 40, 'params' => [$color->id => ['value' => 'Grey'], $size->id => ['value' => 'M'], $material->id => ['value' => 'Cotton']]],
                    ['title' => 'Oversized Heavyweight Tee - Grey L', 'price' => 32, 'old_price' => 40, 'params' => [$color->id => ['value' => 'Grey'], $size->id => ['value' => 'L'], $material->id => ['value' => 'Cotton']]],
                    ['title' => 'Oversized Heavyweight Tee - Navy XL', 'price' => 34, 'old_price' => 42, 'params' => [$color->id => ['value' => 'Navy'], $size->id => ['value' => 'XL'], $material->id => ['value' => 'Cotton']]],
                ],
            ],
            [
                'category' => $shirts,
                'parent' => 'Oxford Button-Down Shirt',
                'children' => [
                    ['title' => 'Oxford Button-Down Shirt - Light Blue S', 'price' => 55, 'old_price' => 70, 'params' => [$color->id => ['value' => 'Light Blue'], $size->id => ['value' => 'S'], $material->id => ['value' => 'Cotton']]],
                    ['title' => 'Oxford Button-Down Shirt - Light Blue M', 'price' => 55, 'old_price' => 70, 'params' => [$color->id => ['value' => 'Light Blue'], $size->id => ['value' => 'M'], $material->id => ['value' => 'Cotton']]],
                    ['title' => 'Oxford Button-Down Shirt - White L', 'price' => 55, 'old_price' => 70, 'params' => [$color->id => ['value' => 'White'], $size->id => ['value' => 'L'], $material->id => ['value' => 'Cotton']]],
                ],
            ],
            [
                'category' => $shirts,
                'parent' => 'Relaxed Linen Summer Shirt',
                'children' => [
                    ['title' => 'Relaxed Linen Summer Shirt - Beige M', 'price' => 62, 'old_price' => 78, 'params' => [$color->id => ['value' => 'Beige'], $size->id => ['value' => 'M'], $material->id => ['value' => 'Linen']]],
                    ['title' => 'Relaxed Linen Summer Shirt - White L', 'price' => 62, 'old_price' => 78, 'params' => [$color->id => ['value' => 'White'], $size->id => ['value' => 'L'], $material->id => ['value' => 'Linen']]],
                    ['title' => 'Relaxed Linen Summer Shirt - Olive XL', 'price' => 64, 'old_price' => 80, 'params' => [$color->id => ['value' => 'Olive'], $size->id => ['value' => 'XL'], $material->id => ['value' => 'Linen']]],
                ],
            ],
            [
                'category' => $jeans,
                'parent' => 'Slim Fit Jeans',
                'children' => [
                    ['title' => 'Slim Fit Jeans - Indigo 30', 'price' => 65, 'old_price' => 80, 'params' => [$color->id => ['value' => 'Indigo'], $size->id => ['value' => '30'], $material->id => ['value' => 'Denim']]],
                    ['title' => 'Slim Fit Jeans - Indigo 32', 'price' => 65, 'old_price' => 80, 'params' => [$color->id => ['value' => 'Indigo'], $size->id => ['value' => '32'], $material->id => ['value' => 'Denim']]],
                    ['title' => 'Slim Fit Jeans - Black 34', 'price' => 70, 'old_price' => 85, 'params' => [$color->id => ['value' => 'Black'], $size->id => ['value' => '34'], $material->id => ['value' => 'Denim']]],
                ],
            ],
            [
                'category' => $jeans,
                'parent' => 'Relaxed Straight Selvedge Jeans',
                'children' => [
                    ['title' => 'Relaxed Straight Selvedge Jeans - Blue 32', 'price' => 85, 'old_price' => 105, 'params' => [$color->id => ['value' => 'Blue'], $size->id => ['value' => '32'], $material->id => ['value' => 'Denim']]],
                    ['title' => 'Relaxed Straight Selvedge Jeans - Blue 34', 'price' => 85, 'old_price' => 105, 'params' => [$color->id => ['value' => 'Blue'], $size->id => ['value' => '34'], $material->id => ['value' => 'Denim']]],
                    ['title' => 'Relaxed Straight Selvedge Jeans - Grey 32', 'price' => 88, 'old_price' => 110, 'params' => [$color->id => ['value' => 'Grey'], $size->id => ['value' => '32'], $material->id => ['value' => 'Denim']]],
                ],
            ],
            [
                'category' => $trousers,
                'parent' => 'Tailored Chino Trousers',
                'children' => [
                    ['title' => 'Tailored Chino Trousers - Beige 30', 'price' => 58, 'old_price' => 72, 'params' => [$color->id => ['value' => 'Beige'], $size->id => ['value' => '30'], $material->id => ['value' => 'Cotton']]],
                    ['title' => 'Tailored Chino Trousers - Navy 32', 'price' => 58, 'old_price' => 72, 'params' => [$color->id => ['value' => 'Navy'], $size->id => ['value' => '32'], $material->id => ['value' => 'Cotton']]],
                    ['title' => 'Tailored Chino Trousers - Olive 34', 'price' => 60, 'old_price' => 75, 'params' => [$color->id => ['value' => 'Olive'], $size->id => ['value' => '34'], $material->id => ['value' => 'Cotton']]],
                ],
            ],
            [
                'category' => $trousers,
                'parent' => 'Pleated Wool Dress Pants',
                'children' => [
                    ['title' => 'Pleated Wool Dress Pants - Charcoal 32', 'price' => 95, 'old_price' => 120, 'params' => [$color->id => ['value' => 'Charcoal'], $size->id => ['value' => '32'], $material->id => ['value' => 'Wool']]],
                    ['title' => 'Pleated Wool Dress Pants - Black 34', 'price' => 95, 'old_price' => 120, 'params' => [$color->id => ['value' => 'Black'], $size->id => ['value' => '34'], $material->id => ['value' => 'Wool']]],
                ],
            ],
            [
                'category' => $sweaters,
                'parent' => 'Merino Wool Crewneck Sweater',
                'children' => [
                    ['title' => 'Merino Wool Crewneck Sweater - Navy S', 'price' => 78, 'old_price' => 95, 'params' => [$color->id => ['value' => 'Navy'], $size->id => ['value' => 'S'], $material->id => ['value' => 'Wool']]],
                    ['title' => 'Merino Wool Crewneck Sweater - Navy M', 'price' => 78, 'old_price' => 95, 'params' => [$color->id => ['value' => 'Navy'], $size->id => ['value' => 'M'], $material->id => ['value' => 'Wool']]],
                    ['title' => 'Merino Wool Crewneck Sweater - Camel L', 'price' => 80, 'old_price' => 100, 'params' => [$color->id => ['value' => 'Camel'], $size->id => ['value' => 'L'], $material->id => ['value' => 'Wool']]],
                ],
            ],
            [
                'category' => $hoodies,
                'parent' => 'Fleece Pullover Hoodie',
                'children' => [
                    ['title' => 'Fleece Pullover Hoodie - Grey M', 'price' => 54, 'old_price' => 68, 'params' => [$color->id => ['value' => 'Grey'], $size->id => ['value' => 'M'], $material->id => ['value' => 'Cotton']]],
                    ['title' => 'Fleece Pullover Hoodie - Black L', 'price' => 54, 'old_price' => 68, 'params' => [$color->id => ['value' => 'Black'], $size->id => ['value' => 'L'], $material->id => ['value' => 'Cotton']]],
                    ['title' => 'Fleece Pullover Hoodie - Olive XL', 'price' => 56, 'old_price' => 70, 'params' => [$color->id => ['value' => 'Olive'], $size->id => ['value' => 'XL'], $material->id => ['value' => 'Cotton']]],
                ],
            ],
        ];

        foreach ($variants as $group) {
            $productGroup = ProductGroup::factory()->create();

            $parentProduct = Product::factory()->create([
                'title' => $group['parent'],
                'category_id' => $group['category']->id,
                'product_group_id' => $productGroup->id,
            ]);

            foreach ($group['children'] as $item) {
                $childProduct = Product::factory()
                    ->nested($parentProduct)
                    ->create([
                        'title' => $item['title'],
                        'price' => $item['price'],
                        'old_price' => $item['old_price'],
                        'category_id' => $group['category']->id,
                        'product_group_id' => $productGroup->id,
                    ]);

                $childProduct->params()->attach($item['params']);
            }
        }
    }
}
