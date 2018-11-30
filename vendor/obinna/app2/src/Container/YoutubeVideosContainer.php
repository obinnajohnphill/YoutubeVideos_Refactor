<?php
/**
 * Created by PhpStorm.
 * User: obinnajohnphill
 * Date: 28/11/18
 * Time: 11:37
 */

namespace Obinna\Container;

use Obinna\Repositories\YoutubeVideosRepository;
use Obinna\YoutubeVideosModel;
use Obinna\Services\YoutubeVideosService;
use Obinna\Controllers\YoutubeVideosController;

class YoutubeVideosContainer
{
    private $container;

    public function getYoutubeVideosRepository()
    {
        $this->container = new YoutubeVideosModel();
        return new YoutubeVideosRepository($this->container);
    }

    public function getYoutubeVideosService ($video_id,$title)
    {
        return new YoutubeVideosService ($video_id,$title);
    }

    public function getYoutubeVideosController($searchItem, $number)
    {
        return new YoutubeVideosController($searchItem, $number);
    }

}