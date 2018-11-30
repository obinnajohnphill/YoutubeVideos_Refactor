<?php
/**
 * Created by PhpStorm.
 * User: obinnajohnphill
 * Date: 14/11/18
 * Time: 18:22
 */

namespace Obinna\Controllers;

class YoutubeVideosController  {

    public $searchterm;

    public $number;


    function __construct($request)
    {
       $this->processRequest($request);
    }


    function processRequest($data)
    {
        $value = json_decode($data,true);
        var_dump($value);

        die();

        session_start();
        $_SESSION['videos'] = $value;
        $payload ['number'] = $this->number;
        if(!empty($value)){
           // $redirect = "../show_videos?".http_build_query($payload);
            //header( "Location: $redirect" );
        }
    }

}
