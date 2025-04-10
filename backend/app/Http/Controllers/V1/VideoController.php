<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreVideoRequest;
use App\Http\Requests\V1\UpdateVideoRequest;
use App\Interfaces\VideoInterface;
use App\Models\Video;


class VideoController extends Controller
{
    private $videoInterface;

    public function __construct(VideoInterface $video)
    {
        $this->videoInterface = $video;
    }

    public function index()
    {
        return $this->videoInterface->getAllVideos();
    }

    
    public function store(StoreVideoRequest $request)
    {
        return $this->videoInterface->storeVideo($request);
    }

    
    public function show(Video $video)
    {
        return $this->videoInterface->getVideo($video);
    }


    public function update(UpdateVideoRequest $request, Video $video)
    {
        return $this->videoInterface->updateVideo($request, $video);
    }

   
    public function destroy(Video $video)
    {
        return $this->videoInterface->deleteVideo($video);
    }
}
