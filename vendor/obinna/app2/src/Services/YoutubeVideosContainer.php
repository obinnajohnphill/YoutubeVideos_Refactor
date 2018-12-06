<?php
/**
 * Created by PhpStorm.
 * User: obinnajohnphill
 * Date: 28/11/18
 * Time: 11:37
 */

namespace Obinna\Services;

use Obinna\Repositories\YoutubeVideosRepository;
use Obinna\YoutubeVideosModel;
use Obinna\Router\Router;
use Obinna\Router\Request;


class YoutubeVideosContainer
{
    private $container;

    public function getYoutubeVideosRepository()
    {
        $this->container = new YoutubeVideosModel();
        return new YoutubeVideosRepository($this->container);
    }

    public function getYoutubeRouter()
    {
        $this->container = new Request();
        return new Router($this->container);
    }

}