<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Http\Requests\V1\StoreCategoryRequest;
use App\Http\Requests\V1\UpdateCategoryRequest;
use App\Interfaces\CategoryInterface;

class CategoryController extends Controller
{

    private $categoryInterface;

    public function __construct(CategoryInterface $category)
    {
        $this->categoryInterface = $category;
    }

    public function index()
    {
         return $this->categoryInterface->getCategories();
    }

    public function store(StoreCategoryRequest $request)
    {
        return $this->categoryInterface->storeCategory($request);
    }


    public function show(Category $category)
    {
        return $this->categoryInterface->getCategory($category);
    }


    public function update(UpdateCategoryRequest $request, Category $category)
    {
        return $this->categoryInterface->updateCategory($request, $category);
    }


    public function destroy(Category $category)
    {
        return $this->categoryInterface->deleteCategory($category);
    }
}