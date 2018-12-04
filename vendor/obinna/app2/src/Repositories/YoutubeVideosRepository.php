<?php
/**
 * Created by PhpStorm.
 * User: obinnajohnphill
 * Date: 14/11/18
 * Time: 18:22
 */

namespace Obinna\Repositories;

use Obinna\YoutubeVideosModel;

use Dotenv;


class YoutubeVideosRepository
{
    public $delete;
    public $duplicated;
    public $video_id;
    public $key;


    public function __construct(YoutubeVideosModel $connect)
    {
        $this->connect = $connect;
        $directory = chop($_SERVER["DOCUMENT_ROOT"],'public');
        $dotenv = new Dotenv\Dotenv($directory.'/');
        $dotenv->load();
        $this->key  = $_ENV['GOOGLE_API_KEY'];
    }

    public function all(){
       return  $this->connect->all();
    }

    public function saveAll($video_id,$title){
      $this->connect->saveAll($video_id, $title);
      return;
    }

    public function checkDuplicate($video_id){
        return $this->connect->checkDuplicate($video_id);
    }

    public function delete($video_id){
        $this->connect->delete($video_id);
    }

    public function savedMessage(){
        return $this->connect->savedMessage();
    }

    public function getYoutubeData($searchterm,$number){

        $stripped = str_replace(' ', '', $searchterm);
        $url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&q='.$stripped.'&maxResults='.$number.'&key='.$this->key ;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL,  $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);

        curl_close($ch);
        $data = json_decode($response);
        $value = json_decode(json_encode($data), true);

        return   $value;
    }

}