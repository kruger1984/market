<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductGroup\StoreRequest;
use App\Http\Requests\Admin\ProductGroup\UpdateRequest;
use App\Http\Resources\ProductGroup\ProductGroupResource;
use App\Models\ProductGroup;
use App\Services\ProductGroupService;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class ProductGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $productGroups = ProductGroup::all();
        $productGroups = ProductGroupResource::collection($productGroups)->resolve();

        return inertia('admin/product-group/Index', compact('productGroups'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return inertia('admin/product-group/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $productGroup = ProductGroupService::store($data);

        return redirect()
            ->route('admin.product-groups.index')
            ->with('success', 'Parent product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductGroup $productGroup): Response
    {
        $productGroup = ProductGroupResource::make($productGroup)->resolve();

        return inertia('admin/product-group/Show', compact('productGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductGroup $productGroup): Response
    {
        $productGroup = ProductGroupResource::make($productGroup)->resolve();

        return inertia('admin/product-group/Edit', compact('productGroup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, ProductGroup $productGroup): RedirectResponse
    {
        $data = $request->validated();
        $productGroup = ProductGroupService::update($productGroup, $data);

        return redirect()
            ->route('admin.product-groups.index')
            ->with('success', 'Parent product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductGroup $productGroup): RedirectResponse
    {
        $productGroup->delete();

        return redirect()
            ->back()
            ->with('success', 'Parent product deleted successfully!');
    }
}
