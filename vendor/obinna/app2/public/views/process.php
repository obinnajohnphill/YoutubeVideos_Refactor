<?php
/**
 * Created by PhpStorm.
 * User: obinnajohnphill
 * Date: 14/11/18
 * Time: 19:30
 */


include dirname(__FILE__).'/../../vendor/autoload.php';


use Obinna\Container\YoutubeVideosContainer;

$container = new YoutubeVideosContainer();
## Process selected-to-save videos

if (!empty($_POST["videoId"]) AND !empty($_POST["title"])){
    $container->getYoutubeVideosService($_POST["videoId"],$_POST["title"]);
}
## Process selected-to-save videos
if (!empty($_POST["videoId"]) AND !empty($_POST["delete"])){
    $container->getYoutubeVideosService($_POST["videoId"],$_POST["delete"]);
}
## Process the search items videos
if (isset($_POST["searchterm"]) AND isset($_POST["number"]) )
{
    $searchItem =  htmlspecialchars($_POST["searchterm"]);
    $number = htmlspecialchars($_POST["number"]);

    if (empty($searchItem) OR empty($number))
    {
        echo "<h1>Error!!</h1>";
        echo "<h3>Please enter a search term then try again</h3>";
        echo "<h5><a href='/'>Go back</a></h5>";
        die();
    }else{
        $container->getYoutubeVideosController($searchItem, $number);
    }
}



