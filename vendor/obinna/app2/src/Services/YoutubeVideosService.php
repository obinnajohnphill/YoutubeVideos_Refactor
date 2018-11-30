<?php
/**
 * Created by PhpStorm.
 * User: obinnajohnphill
 * Date: 14/11/18
 * Time: 18:24
 */

namespace Obinna\Services;


use Obinna\RabbitMQ\SendMessage;
use Obinna\Container\YoutubeVideosContainer;

class YoutubeVideosService
{

   public $video_id;
   public $title;
   public $container;

   public function __construct($videId,$title)
   {
       $con = new YoutubeVideosContainer();
       $this->container = $con->getYoutubeVideosRepository();

       $this->video_id = $videId;
       $this->title = $title;
       if ($this->title != "delete"){
           $this->saveVideos();
       }else{
           $this->deleteVideos();
       }

   }

   public function saveVideos(){
       for ($i = 0; $i < count($this->video_id); $i++) {
           $isduplicate = $this->container->checkDuplicate($this->video_id[$i],$this->title[$i]);
           if ($isduplicate == true){
               new SendMessage();
               $this->container->saveAll($this->video_id[$i],$this->title[$i]);
           }
       }
   }

   public function deleteVideos(){
       for ($i = 0; $i < count($this->video_id); $i++) {
           $this->container->delete($this->video_id[$i]);
       }
   }

}