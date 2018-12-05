<?php
/**
 * Created by PhpStorm.
 * User: obinnajohnphill
 * Date: 14/11/18
 * Time: 18:22
 */

namespace Obinna\Controllers;

use Obinna\Container\YoutubeVideosContainer;

class YoutubeVideosController
{

    function __construct($request)
    {

        if (isset($request['searchterm'])){
            $this->processRequest($request);
        }
        if (!empty($request['checkbox'])){
            $this->saveData($request);
        }
        if (isset($request['delete'])){
            $this->deleteData($request['videoId']);
           // var_dump($request);
           // die();
        }
    }


    function processRequest($data)
    {
        $container = new YoutubeVideosContainer();
        $youtube_api = $container->getYoutubeVideosRepository();
        $value = $youtube_api->getYoutubeData($data['searchterm'], $data['number']);
        session_start();
        $_SESSION['videos'] = $value;
        if(!empty($value)){
            $redirect = "../show_videos";
            header( "Location: $redirect" );
        }
    }

    public function saveData($data){
            $container = new YoutubeVideosContainer();
            $insert = $container->getYoutubeVideosRepository();
            $insert->saveAll($data);
    }

    public function deleteData($videoId){
        $container = new YoutubeVideosContainer();
        $insert = $container->getYoutubeVideosRepository();
        $insert->delete($videoId);
    }

}
