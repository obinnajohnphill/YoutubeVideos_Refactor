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
        if (isset($request['videoId'])){
            $this->processData($request);
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

    public function processData($data){
        for($i=0; $i < count($data['videoId']); $i++){
            $container = new YoutubeVideosContainer();
            $insert = $container->getYoutubeVideosRepository();
            $insert->saveAll($data['videoId'][$i],$data['title'][$i]);
        }

    }

}
