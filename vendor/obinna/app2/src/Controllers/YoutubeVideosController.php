<?php
/**
 * Created by PhpStorm.
 * User: obinnajohnphill
 * Date: 14/11/18
 * Time: 18:22
 */

namespace Obinna\Controllers;

use Obinna\Services\YoutubeVideosContainer;

class YoutubeVideosController
{
    public $payload;

    function __construct($request)
    {
       // var_dump($request);
        //die();

        if (isset($request['searchterm'])){
            $this->processRequest($request);
        }
        if (!empty($request['checkbox'])){
            $this->saveData($request);
        }
        if (isset($request['delete'])){
            $this->deleteData($request['videoId']);
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
        $delete = $container->getYoutubeVideosRepository();
        $delete->delete($videoId);
    }

    public function getAllVideos(){
        $container = new YoutubeVideosContainer();
        $select = $container->getYoutubeVideosRepository();
        $data = $select->all();
        //echo count($data['videoId']);
        for($i=0; $i < count($data['videoId']); $i++){
            $this->payload[] = array ('videoId'=>$data['videoId'][$i],'title'=>$data['title'][$i]);
        }
        //var_dump($this->payload);
        //die();
        session_start();
        $_SESSION['data']=$this->payload;
        $redirect = "../saved_videos";
        header( "Location: $redirect" );
    }

}
