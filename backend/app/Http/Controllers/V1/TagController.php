<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreTagRequest;
use App\Http\Requests\V1\UpdateTagRequest;
use App\Interfaces\TagInterface;
use App\Models\Tag;

class TagController extends Controller
{
    private $tagInterface;

    public function __construct(TagInterface $tagInterface)
    {
        $this->tagInterface = $tagInterface;
    }
    public function index()
    {
        return $this->tagInterface->getTags();
    }

   
    public function store(StoreTagRequest $request)
    {
        return $this->tagInterface->storeTag($request);
    }

   
    // public function show(Tag $tag)
    // {
    //     return $this->tagInterface->getTags();
    // }

  
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        return $this->tagInterface->updateTag($request, $tag);
    }

   
    public function destroy(Tag $tag)
    {
        return $this->tagInterface->deleteTag($tag);
    }
}
