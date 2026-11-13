<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductWithGroupedParamResource;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ParamProductService;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(): Response
    {
        $products = ProductResource::collection(Product::whereNull('parent_id')->get())->resolve();

        return inertia('client/product/Index', compact('products'));
    }

    public function show(Product $product): Response
    {
        $breadcrumbs = CategoryService::getCategoryParents($product->category);
        $breadcrumbs = CategoryResource::collection($breadcrumbs->push($product->category))->resolve();

        $paramProducts = ParamProductService::getGroupedByParamArray($product);
        $product = ProductWithGroupedParamResource::make($product)->resolve();

        return inertia('client/product/Show', compact('product', 'breadcrumbs', 'paramProducts'));
    }
}
