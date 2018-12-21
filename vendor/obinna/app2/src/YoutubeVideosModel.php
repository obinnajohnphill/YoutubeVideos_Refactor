<?php
/**
 * Created by PhpStorm.
 * User: obinnajohnphill
 * Date: 14/11/18
 * Time: 18:24
 */

namespace Obinna;

use Dotenv;
use PDO;
use PDOException;
use Memcached;
use Obinna\RabbitMQ\SendMessage;

class YoutubeVideosModel
{

    public $data;
    public $duplicate;
    public $conn;
    public $memcached;
    public $memcached_key = "select";
    protected $memcached_server;
    protected $memcached_server_port;

    public function __construct(){
        $directory = chop($_SERVER["DOCUMENT_ROOT"],'public');
        $dotenv = new Dotenv\Dotenv($directory.'/');
        $dotenv->load();
        $this->memcached = new Memcached();
        $this->memcached ->addServer($_ENV['MEMCACHED_SERVER'],$_ENV['MEMCACHED_SERVER_PORT']);
        try{
            $this->conn = new PDO('mysql:host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_NAME'].'', $_ENV['DB_USER'], $_ENV['DB_PWD']);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
            echo "Database connection failed: " . $e->getMessage();
        }
     }

    public function all(){
        try{
            $this->memcached->flush();
            ## Get result from memcached if data exists in cache
            $cached = $this->memcached->get("select");
            if ($this->memcached->getResultCode() !== Memcached::RES_NOTFOUND) {
                if (!empty($cached)){
                    echo "Cached Data:  ";
                    return  $cached;
                }
            }
            ## Run query to get data if no longer in cache
            $statement  = $this->conn->prepare("SELECT * FROM  videos");
            $statement ->execute();
            while ( $row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                $videoId[] = $row['video_id'];
                $title[] = $row['title'];
                $this->data = array("videoId"=>$videoId,"title"=>$title);
            }

            $this->memcached->set("select", $this->data, 60*60); ## Sets data into cache

            return  $this->data;

        }
        catch(PDOException $e)
        {
            echo "Select all failed: " . $e->getMessage();
        }
    }


    public function saveAll($data)
    {
        try {

            for ($i= 0; $i < count($data['videoId']); $i++) {

                $video_id = $data['videoId'][$i];
                $title = $data['title'][$i];

                $checkDuplicate = $this->checkDuplicate($data['videoId'][$i]);

                if ($checkDuplicate > 0) {
                    session_start();
                    $_SESSION['duplicate'] = "Duplicate video exists in database: " . $title;
                    $redirect = "../";
                    header("Location: $redirect");
                    die();
                }

                if ($video_id != null){
                    $remove_quotes = str_replace('"', '', $title);
                    $video_title = str_replace("'", '', $remove_quotes);
                    $statement = $this->conn->prepare("INSERT INTO videos (video_id, title) VALUES ('$video_id','$video_title')");
                    $statement->execute();
                    $statement = null;
                }
            }

                $this->memcached->flush();
                new SendMessage();
                include_once $_SERVER["DOCUMENT_ROOT"]."/Send.php";
                new \Send($data); ## Send data to Kafka
                //require_once $_SERVER["DOCUMENT_ROOT"] . '/views/saved_videos.php';
                $redirect = "../saved_videos";
                header( "Location: $redirect" );


        }
        catch(PDOException $e)
        {
            echo "Insert failed: " . $e->getMessage();
        }

    }


    public function checkDuplicate($video_id){
     try {
            $statement = $this->conn->prepare("SELECT * FROM  videos WHERE video_id = '$video_id'");
            $statement->execute();
            $number_of_rows = $statement->rowCount();
            return  $number_of_rows;
        }
        catch(PDOException $e)
        {
            echo "Check num-rows failed: " . $e->getMessage();
        }

    }


    public function delete($video_id){
        try{
            if (!empty($video_id['checkbox'])){
                for ($i = 0; $i < count($video_id['checkbox']); $i++){
                    $video = $video_id['videoId'][$i];
                    $statement = $this->conn->prepare("DELETE FROM videos WHERE video_id = '$video'");
                    $statement->execute();
                    $statement = null;
                    $this->memcached->flush();

                }
            }
            $redirect = "../saved_videos";
            header("Location: $redirect");
            die();

        }
        catch(PDOException $e)
        {
            echo "Delete failed: " . $e->getMessage();
        }
    }


}