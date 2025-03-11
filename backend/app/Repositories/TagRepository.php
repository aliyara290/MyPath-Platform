<?php

namespace App\Repositories;

use App\Http\Resources\V1\TagCollection;
use App\Interfaces\TagInterface;
use App\Models\Tag;
use App\Traits\HttpResponses;
use Exception;

class TagRepository implements TagInterface
{
    use HttpResponses;
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    public function getTags()
    {
        try {
            $tags = Tag::get();

            if (!$tags->isEmpty()) {
                return response()->json(["message" => "No tags to show!"], 404);
            }
            return new TagCollection(Tag::paginate(8));
        } catch (Exception $e) {
            return $this->error(
                '',
                'Failed to show tags',
                500
            );
        }
    }
    public function storeTag($request) {
        try {
            $tag = Tag::create([
                "name" => $request->name,
            ]);
            
            return $this->success([
                "tag" => $tag,
                "message" => "Tag added successfully",
            ]);

        } catch (Exception $e) {
            return $this->error(
                '',
                'Failed to create tag'
            );
        }
    }
    public function updateTag($request, $tag) {
        try {
            $tag = Tag::find($tag)->first();
            $tag->update([
                "name" => $request->name
            ]);

            return $this->success([
                "tag" => $tag,
                "message" => "Tag updated successfully",
            ]);

        } catch (Exception $e) {
            return $this->error(
                '',
                'Failed to update tag'
            );
        }
    }
    public function deleteTag($tag) {
        try {
            $tag = Tag::find($tag)->first();
            $tag->delete();
            return $this->success([
                "tag" => $tag,
                "message" => "Tag deleted successfully",
            ]);
        } catch(Exception $e) {
            return $this->error(
                '',
                'Failed to delete tag'
            );
        }
    }
}
