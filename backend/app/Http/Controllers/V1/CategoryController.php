<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\V1\StoreCategoryRequest;
use App\Http\Requests\V1\UpdateCategoryRequest;
use App\Interfaces\CategoryInterface;
use OpenApi\Annotations as OA;


class CategoryController extends Controller
{
    private $categoryInterface;

    public function __construct(CategoryInterface $category)
    {
        $this->categoryInterface = $category;
    }

    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Get a list of categories",
     *     tags={"Category"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function index()
    {
        return $this->categoryInterface->getCategories();
    }

    /**
     * @OA\Post(
     *     path="/api/categories",
     *     summary="Store a new category",
     *     tags={"Category"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Technology")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Category created"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function store(StoreCategoryRequest $request)
    {
        return $this->categoryInterface->storeCategory($request);
    }

    /**
     * @OA\Get(
     *     path="/api/categories/{id}",
     *     summary="Get category details",
     *     tags={"Category"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Category ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Category not found")
     * )
     */
    public function show(Category $category)
    {
        return $this->categoryInterface->getCategory($category);
    }

    /**
     * @OA\Put(
     *     path="/api/categories/{id}",
     *     summary="Update a category",
     *     tags={"Category"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Category ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Science")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Category updated"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        return $this->categoryInterface->updateCategory($request, $category);
    }

    /**
     * @OA\Delete(
     *     path="/api/categories/{id}",
     *     summary="Delete a category",
     *     tags={"Category"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Category ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Category deleted"),
     *     @OA\Response(response=404, description="Category not found")
     * )
     */
    public function destroy(Category $category)
    {
        return $this->categoryInterface->deleteCategory($category);
    }
}
