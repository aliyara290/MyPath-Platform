<?php

namespace App\Repositories;

use App\Http\Requests\V1\StoreCategoryRequest;
use App\Http\Resources\V1\CategoryCollection;
use App\Http\Resources\V1\CategoryResource;
use App\Interfaces\CategoryInterface;
use App\Models\Category;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Support\Facades\Gate;

class CategoryRepository implements CategoryInterface
{


    use HttpResponses;


    public function getCategories()
    {
        try {
            $categories = Category::whereNull("parent_id")->with("children")->get();
            if ($categories->isEmpty()) {
                return response()->json(["message" => "No categories to show!"], 404);
            }
            return new CategoryCollection(Category::paginate(8));
        } catch (Exception $e) {
            return $this->error(
                '',
                'Failed to show categories',
                500
            );
        }
    }

    public function getCategory($category)
    {
        try {
            $category = Category::find($category)->first();
            return new CategoryResource($category);
        } catch (Exception $e) {
            return $this->error(
                '',
                'Failed to show category'
            );
        }
    }

    public function storeCategory($request)
    {
        try {
            $category = Category::create([
                "name" => $request->name,
                "icon" => $request->icon,
                "parent_id" => $request->parentId,
            ]);

            return $this->success([
                "category" => $category,
                "message" => "Category added successfully",

            ], 201);
        } catch (Exception $e) {
            return $this->error(
                '',
                500,
                'Failed to create category'
            );

            // return $e->getMessage();
        }
    }

    public function updateCategory($request, $category)
    {
        try {
           
            $category = Category::find($category)->first();
            $category->update([
                "name" => $request->name,
                "icon" => $request->icon
            ]);

            return $this->success([
                "category" => $category,
                "message" => "Category updated successfully",
            ]);
        } catch (Exception $e) {
            return $this->error(
                '',
                'Failed to update category'
            );
        }
    }

    public function deleteCategory($category)
    {
        try {
            $category = Category::find($category)->first();
            $category->delete();
            return $this->success([
                "category" => $category,
                "message" => "Category deleted successfully",
            ]);
        } catch (Exception $e) {
            return $this->error(
                '',
                'Failed to delete category'
            );
        }
    }
}
