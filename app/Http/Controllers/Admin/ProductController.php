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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Throwable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $products = Product::whereNull('parent_id')->withCount('children')->orderBy('id')->get();
        $products = ProductResource::collection($products)->resolve();

        return inertia('admin/product/Index', compact('products'));
    }

    /**
     * Display a listing of the resource.
     */
    public function indexChildren(Product $product): JsonResponse
    {
        $children = $product->children;

        return response()->json(
            ProductResource::collection($children)->resolve()
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return inertia('admin/product/Create', $this->getFormReferences());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws Throwable
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        return $this->handleAction(function () use ($request): RedirectResponse {
            ProductService::store($request->validationData());

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product created successfully!');
        }, 'Error creating product!');
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
        return inertia('admin/product/Edit', [
            'product' => ProductResource::make($product)->resolve(),
            ...$this->getFormReferences(),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function replicate(Product $product): RedirectResponse
    {
        return $this->handleAction(function () use ($product): RedirectResponse {
            $cloneProduct = ProductService::replicate($product);

            return redirect()
                ->route('admin.products.edit', $cloneProduct)
                ->with('success', 'Product replicated successfully!');
        }, 'Error cloning product!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws Throwable
     */
    public function update(UpdateRequest $request, Product $product): RedirectResponse
    {
        return $this->handleAction(function () use ($request, $product): RedirectResponse {
            ProductService::update($product, $request->validationData());

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product updated successfully!');
        }, 'Error updating product!');
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

    /**
     * @return array{
     *     categories: array<int|string, mixed>,
     *     productGroups: array<int|string, mixed>,
     *     params: array<int|string, mixed>,
     * }
     */
    private function getFormReferences(): array
    {
        return [
            'categories' => CategoryResource::collection(Category::all())->resolve(),
            'productGroups' => ProductGroupResource::collection(ProductGroup::all())->resolve(),
            'params' => ParamResource::collection(Param::all())->resolve(),
        ];
    }

    private function handleAction(callable $callback, string $errorMessage): RedirectResponse
    {
        try {
            return $callback();
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $errorMessage);
        }
    }
}
