<?php

## Get project host address
$host_address = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

## Split host address into components
$pages = (parse_url($host_address, PHP_URL_PATH));

## Route it up!
switch ($pages) {
    case '/':
        require 'views/home.php';
        break;
    case '/show_videos':
        require 'views/show_videos.php';
        break;
    case '/saved_videos':
        require 'views/saved_videos.php';
        break;
    case '/process':
        require 'views/process.php';
        break;
    default:
        header('HTTP/1.0 404 Not Found');
        require 'views/404.php';
        break;
}