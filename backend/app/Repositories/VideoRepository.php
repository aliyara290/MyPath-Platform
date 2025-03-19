<?php

namespace App\Repositories;

use App\Http\Resources\V1\VideoCollection;
use App\Http\Resources\V1\VideoResource;
use App\Interfaces\VideoInterface;
use App\Models\Video;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Database\QueryException;

class VideoRepository implements VideoInterface
{
    use HttpResponses;

    public function getAllVideos()
    {
        try {
            $videos = Video::paginate(8);
            if($videos->isEmpty()) {
                return response()->json(["message" => "There is no video to show!"]);
            }
            return new VideoCollection($videos);
        } catch (Exception $e) {
            return $this->error(
                "",
                500,
                $e->getMessage()
            );
        }
    }
    public function getVideo($video)
    {
        try {
            $video = Video::find($video);
            if (!$video) {
                return $this->error(
                    "",
                    404,
                    "Video not Found"
                );
            }
            return new VideoResource($video);
        } catch (Exception $e) {
            return $this->error(
                "",
                500,
                $e->getMessage()
            );
        }
    }
    public function storeVideo($request)
    {
        try {
            $video = Video::create($request->validated());

            return $this->success(
                $video,
                "Video added successfully",
                201
            );
        } catch (QueryException $e) {
            return $this->error(
                "Database error",
                500,
                $e->getMessage()
            );
        } catch (Exception $e) {

            return $this->error(
                "Something went wrong",
                500,
                $e->getMessage()
            );
        }
    }

    public function updateVideo($request, $video) {
        try {
            

            if(!$video) {
                return $this->error(
                    "",
                    404,
                    "Video not found",
                );
            }

            $video->update($request->validated());

            return $this->success(
                $video,
                "Video updated successfully",
                200
            );
        } catch (QueryException $e) {
            return $this->error(
                "Database error",
                500,
                $e->getMessage()
            );
        } catch (Exception $e) {

            return $this->error(
                "Something went wrong",
                500,
                $e->getMessage()
            );
        }
    }
    public function deleteVideo($video) {

        try {

            if(!$video) {
                return $this->error(
                    "",
                    404,
                    "Video not found",
                );
            }

            $video->delete();

            return $this->success(
                $video,
                "Video deleted successfully",
                200
            );
        } catch (QueryException $e) {
            return $this->error(
                "Database error",
                500,
                $e->getMessage()
            );
        } catch (Exception $e) {

            return $this->error(
                "Something went wrong",
                500,
                $e->getMessage()
            );
        }
    }
}
