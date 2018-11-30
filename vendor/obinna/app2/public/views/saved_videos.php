<!doctype html>
<html>
<head>
    <title>YouTube Search</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/views.css">
    <script src="../js/views.js"></script>

</head>

<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">All Saved Videos</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="/">Home</a></li>
        </ul>
    </div>
</nav>

<?php

include dirname(__FILE__).'/../../vendor/autoload.php';

use Obinna\Container\YoutubeVideosContainer;

if (!empty ($_GET['msg'])){
    $message = $_GET['msg'];
    echo '<div style="color:#4a8b15">' .$message.'</div>';
}
if (!empty ($_GET['delete-msg'])){
    $message = $_GET['delete-msg'];
    echo '<div style="color:red">' .$message.'</div>';
}

## Call the a function within the Repository via the Container to get all videos
$container = new YoutubeVideosContainer();
$function = $container->getYoutubeVideosRepository();
$showall = $function->all();

if ($showall == null){
    echo "There are no videos in the database";
}

?>

<a rel="group_1" href="#select_all" align ="right" <?php if (count($showall) == 0){echo 'style= "display: none;"';} ?>>Select All</a>&ensp;
<a rel="group_1" href="#select_none" <?php if (count($showall) == 0){echo 'style= "display: none;"';} ?>>Select None</a>&ensp;
<a rel="group_1" href="#invert_selection" <?php if (count($showall) == 0){echo 'style= "display: none;"';} ?>>Invert Selection</a>

<form action="/process" method="post">
<?php
if (!empty($showall['videoId'])){
for ($i = 0; $i < count($showall['videoId']); $i++) {
    $videoId = $showall['videoId'][$i];
    $title = $showall['title'][$i];
    ?>
    <div class="video-tile">
        <div class="videoDiv">
            <iframe id="iframe" style="width:100%;height:100%" src="//www.youtube.com/embed/<?php echo $videoId; ?>"
                    data-autoplay-src="//www.youtube.com/embed/<?php echo $videoId; ?>?autoplay=1"></iframe>
        </div>
        <fieldset id="group_1">
            <input type="checkbox" name="videoId[]" value="<?php echo $videoId; ?>"><br>
            <input type="hidden" name="delete" value="delete">
        </fieldset>
        <div class="videoInfo">
            <div class="videoTitle"><b><?php echo $title; ?></b></div>
        </div>
    </div>
    <?php
  }
}

?>
<input type="submit" class="btn btn-danger btn-lg" value="Delete" <?php if (count($showall) == 0){echo 'style= "display: none;"';} ?>/ >
</form>
</body>
</html>