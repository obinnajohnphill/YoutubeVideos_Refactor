<?php

include dirname(__FILE__).'/../vendor/autoload.php';

use Obinna\Router\Router;
use Obinna\Router\Request;


$router = new Router(new Request);

$request = "";

$router->get('/', function() {
    require 'views/home.php';
});

$router->get('/show_videos', function() {
    require 'views/show_videos.php';
});


$router->get('/saved_videos', function() {
    require 'views/saved_videos.php';
});


$router->get('/data', function() {
    $controller = new \Obinna\Controllers\YoutubeVideosController(null);
    $controller->getAllVideos();
});


$router->get('/404', function() {
    require 'views/404.php';
});

$router->post('/process', function($request) {
    return json_encode($request->getBody());
});