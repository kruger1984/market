<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Category\ProductIndexRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Mappers\Client\CategoryMapper;
use App\Models\Category;
use Inertia\Response;

class CategoryController extends Controller
{
    public function index(): Response
    {
        $categories = CategoryResource::collection(Category::whereNull('parent_id')->get())->resolve();

        return inertia('client/category/Index', compact('categories'));
    }

    /**
     * @param  Category  $category
     * @param  ProductIndexRequest  $request
     *
     * @return Response|array<int, mixed>
     */
    public function productIndex(Category $category, ProductIndexRequest $request): Response|array
    {
        $data = $request->validated();

        if ($request->wantsJson()) {
            return CategoryMapper::productIndexAsJson($category, $data);
        }

        CategoryMapper::productIndex($category, $data);

        return inertia('client/product/ProductIndex', CategoryMapper::productIndex($category, $data));
    }
}
