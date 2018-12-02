<?php

include dirname(__FILE__).'/../vendor/autoload.php';

use Obinna\Container\YoutubeVideosContainer;


$router = new YoutubeVideosContainer();
$router->getYoutubeRouter();

$router->get('/', function() {
    require 'views/home.php';
});

$router->get('/show_videos', function($request) {
    require 'views/show_videos.php';
});

$router->get('/saved_videos', function($request) {
    require 'views/saved_videos.php';
});


$router->get('/404', function($request) {
  require 'views/404.php';
});

$router->post('/process', function($request) {
    return json_encode($request->getBody());
});