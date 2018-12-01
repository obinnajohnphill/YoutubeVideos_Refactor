<?php
/**
 * Created by PhpStorm.
 * User: obinnajohnphill
 * Date: 14/11/18
 * Time: 18:22
 */

namespace Obinna\Controllers;

use Obinna\Container\YoutubeVideosContainer;

class YoutubeVideosController  {

    function __construct($request)
    {
       $this->processRequest($request);
    }


    function processRequest($data)
    {


        $call = new YoutubeVideosContainer();
        $youtube_api = $call->getYoutubeVideosRepository();
        $value = $youtube_api->getYoutubeData($data['searchterm'],$data['number']);

        var_dump($value);
        die();

        $_SESSION['videos'] = $data;
        if (!empty($data['number'])){
            $payload['number'] = $data['number'];
        }

        if(!empty($data)){

            header("Location: http://job.test/show_videos?".http_build_query($payload));
            die();

           // $redirect = "../show_videos?".http_build_query($payload);

           // $redirect = "../show_videos".http_build_query($payload);
           header( "Location: $redirect" );
        }
    }

}
