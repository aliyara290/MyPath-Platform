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

     /**
     * @OA\Get(
     *     path="/api/tags",
     *     summary="Get a list of tags",
     *     tags={"Tags"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function index()
    {
        return $this->tagInterface->getTags();
    }

   /**
     * @OA\Post(
     *     path="/api/tags",
     *     summary="Store a new Tag",
     *     tags={"Tags"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Tag created"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function store(StoreTagRequest $request)
    {
        return $this->tagInterface->storeTag($request);
    }

   
    // public function show(Tag $tag)
    // {
    //     return $this->tagInterface->getTags();
    // }

  /**
     * @OA\Put(
     *     path="/api/tags/{id}",
     *     summary="Update a Tag",
     *     tags={"Tags"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Tag ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Tag updated"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        return $this->tagInterface->updateTag($request, $tag);
    }

    /**
     * @OA\Delete(
     *     path="/api/tags/{id}",
     *     summary="Delete a Tag",
     *     tags={"Tags"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Tag ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Tag deleted"),
     *     @OA\Response(response=404, description="Tag not found")
     * )
     */
    public function destroy(Tag $tag)
    {
        return $this->tagInterface->deleteTag($tag);
    }
}
