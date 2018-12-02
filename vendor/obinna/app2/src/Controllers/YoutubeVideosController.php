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
    public $processData;
    function __construct($request)
    {
        $this->processRequest($request);
    }


    function processRequest($data)
    {
        var_dump($data);
        die();

        $call = new YoutubeVideosContainer();
        $youtube_api = $call->getYoutubeVideosRepository();
        $value = $youtube_api->getYoutubeData($data['searchterm'], $data['number']);
        session_start();
        $_SESSION['videos'] = $value;
        if(!empty($value)){
            $redirect = "../show_videos";
            header( "Location: $redirect" );
        }
    }

    public function insertData(){

    }


}
