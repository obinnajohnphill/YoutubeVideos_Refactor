<?php
/**
 * Created by PhpStorm.
 * User: obinnajohnphill
 * Date: 14/11/18
 * Time: 18:22
 */

Controllers;


$directory = chop($_SERVER["DOCUMENT_ROOT"],'public');
require_once ("$directory./vendor/autoload.php");

use Dotenv;

class YoutubeVideosController {

    public $searchterm;

    public $number;


    function __construct($searchTerm, $number)
    {
        $this->searchterm = $searchTerm;
        $this->number = $number;
        $this->processRequest();
    }

    public function pageNotFound(){
        die("died");
    }

    function processRequest()
    {
        $directory = chop($_SERVER["DOCUMENT_ROOT"],'public');
        $dotenv = new Dotenv\Dotenv($directory.'/');
        $dotenv->load();
        $key  = $_ENV['GOOGLE_API_KEY'];
        $stripped = str_replace(' ', '', $this->searchterm);
        $url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&q='.$stripped.'&maxResults='.$this->number.'&key='.$key;

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

        session_start();
        $_SESSION['videos'] = $value;
        $payload ['number'] = $this->number;
        if(!empty($value)){
            $redirect = "../show_videos?".http_build_query($payload);
            header( "Location: $redirect" );
        }
    }

}
