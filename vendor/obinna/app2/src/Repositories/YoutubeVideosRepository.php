<?php
/**
 * Created by PhpStorm.
 * User: obinnajohnphill
 * Date: 14/11/18
 * Time: 18:22
 */

namespace Obinna\Repositories;


use Obinna\YoutubeVideosModel;




class YoutubeVideosRepository
{
    public $delete;
    public $duplicated;
    public $video_id;


    public function __construct(YoutubeVideosModel $connect)
    {
      $this->connect = $connect;
    }

    public function all(){
       return  $this->connect->all();
    }

    public function saveAll($video_id,$title){
      $this->connect->saveAll($video_id, $title);
      return;
    }

    public function checkDuplicate($video_id,$title){
        return $this->connect->checkDuplicate($video_id, $title);
    }

    public function delete($video_id){
        $this->connect->delete($video_id);
    }

}