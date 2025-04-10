<?php

namespace App\Interfaces;

interface VideoInterface
{
    public function getAllVideos();
    public function getVideo($video);
    public function storeVideo($request);
    public function updateVideo($request, $video);
    public function deleteVideo($video);
}
