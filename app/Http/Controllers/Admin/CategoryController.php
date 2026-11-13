<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreRequest;
use App\Http\Requests\Admin\Category\UpdateRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $categories = Category::with('parent')->get();

        $categories = CategoryResource::collection($categories)->resolve();

        return inertia('admin/category/Index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $categories = CategoryResource::collection(Category::all())->resolve();

        return inertia('admin/category/Create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        CategoryService::store($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): Response
    {
        $category = CategoryResource::make($category)->resolve();

        return inertia('admin/category/Show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): Response
    {
        $category->load('children');

        $categories = Category::where('id', '!=', $category->id)->get();

        return inertia('admin/category/Edit', [
            'category' => CategoryResource::make($category)->resolve(),
            'categories' => CategoryResource::collection($categories)->resolve(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();
        CategoryService::update($category, $data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()
            ->back()
            ->with('success', 'Category deleted successfully!');
    }
}
