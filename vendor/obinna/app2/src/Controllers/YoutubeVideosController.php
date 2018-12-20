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
    public $value;

    function __construct($request)
    {

        if (isset($request['delete'])){
                $this->deleteData($request);
        }
        if (isset($request['searchterm'])){
            $this->processRequest($request);
        }
        if (!empty($request['checkbox'])){
            $this->saveData($request);
        }

    }


    function processRequest($data)
    {
        $container = new YoutubeVideosContainer();
        $youtube_api = $container->getYoutubeVideosRepository();
        $this->value = $youtube_api->getYoutubeData($data['searchterm'], $data['number']);
        require_once $_SERVER["DOCUMENT_ROOT"] . '/views/show_videos.php';
        return $this->value;
    }

    public function saveData($data){
            $container = new YoutubeVideosContainer();
            $insert = $container->getYoutubeVideosRepository();
            $insert->saveAll($data);
    }

    public function deleteData($request){
            $container = new YoutubeVideosContainer();
            $delete = $container->getYoutubeVideosRepository();
            $delete->delete($request);
    }

    public function getAllVideos(){
        $container = new YoutubeVideosContainer();
        $select = $container->getYoutubeVideosRepository();
        $data = $select->all();

        for($i=0; $i < count($data['videoId']); $i++){
            $this->payload[] = array ('videoId'=>$data['videoId'][$i],'title'=>$data['title'][$i]);
        }

       require_once $_SERVER["DOCUMENT_ROOT"] . '/views/saved_videos.php';

    }


}
