<?php

namespace App\Interfaces;

interface TagInterface
{
    public function getTags();
    public function storeTag($request);
    public function updateTag($request, $tag);
    public function deleteTag($tag);
}
