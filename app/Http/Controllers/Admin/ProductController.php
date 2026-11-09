<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Param\ParamResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\ProductGroup\ProductGroupResource;
use App\Models\Category;
use App\Models\Param;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $products = Product::all();
        $products = ProductResource::collection($products)->resolve();

        return inertia('admin/product/Index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $categories = CategoryResource::collection(Category::all())->resolve();
        $productGroups = ProductGroupResource::collection(ProductGroup::all())->resolve();

        return inertia('admin/product/Create', compact('categories', 'productGroups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validationData();
        $product = ProductService::store($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): Response
    {
        $product = ProductResource::make($product)->resolve();

        return inertia('admin/product/Show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): Response
    {
        $product = ProductResource::make($product)->resolve();
        $categories = CategoryResource::collection(Category::all())->resolve();
        $productGroups = ProductGroupResource::collection(ProductGroup::all())->resolve();
        $params = ParamResource::collection(Param::all())->resolve();

        return inertia('admin/product/Edit', compact('product', 'categories', 'productGroups', 'params'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validationData();
        $product = ProductService::update($product, $data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->back()
            ->with('success', 'Product deleted successfully!');
    }
}
