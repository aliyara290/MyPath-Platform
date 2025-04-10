<?php

namespace App\Interfaces;

interface CategoryInterface
{
    public function getCategories();
    public function getCategory($category);
    public function storeCategory($request);
    public function updateCategory($request, $category);
    public function deleteCategory($category);
}