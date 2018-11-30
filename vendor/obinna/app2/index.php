<?php
require "vendor/autoload.php";

use Obinna\YoutubeVideosModel;
use Obinna\Controllers\YoutubeVideosController;


$user = new YoutubeVideosModel();
$page = new YoutubeVideosController();

$helloUser = $user->sayhello();
$hellopage = $page->another();

echo $helloUser;
echo $hellopage;