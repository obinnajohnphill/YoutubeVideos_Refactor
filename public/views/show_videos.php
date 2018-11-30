
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
            <a class="navbar-brand" href="#">Search Result</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="/">Home</a></li>
            <li><a href="/saved_videos">All Saved Videos</a></li>
        </ul>
    </div>
</nav>

<a rel="group_1" href="#select_all" align ="right">Select All</a>&ensp;
<a rel="group_1" href="#select_none">Select None</a>&ensp;
<a rel="group_1" href="#invert_selection">Invert Selection</a>

<form action="/process" method="post">
<?php

session_start();


if(isset($_SESSION['videos']) && isset($_GET['number'])) {
    for ($i = 0; $i < $_GET['number']; $i++) {
        if (!empty($_SESSION['videos']['items'][$i]['id']['videoId'])){
            $videoId = $_SESSION['videos']['items'][$i]['id']['videoId'];
            $title = $_SESSION['videos'] ['items'][$i]['snippet']['title'];
            $description = $_SESSION['videos']['items'][$i]['snippet']['description'];
        ?>
        <div class="video-tile">
            <div class="videoDiv">
                <iframe id="iframe" style="width:100%;height:100%" src="//www.youtube.com/embed/<?php echo $videoId; ?>"
                        data-autoplay-src="//www.youtube.com/embed/<?php echo $videoId; ?>?autoplay=1"></iframe>
            </div>

            <fieldset id="group_1">
            <input type="checkbox" name="videoId[]" value="<?php echo $videoId; ?>"><br>
            <input type="hidden" name="title[]" value="<?php echo $title; ?>">
            </fieldset>

            <div class="videoInfo">
                <div class="videoTitle"><b><?php echo $title; ?></b></div>
                <div class="videoDesc"><?php echo $description; ?></div>
            </div>
        </div>
        <?php
        }
    }
}
?>
<input type="submit" class="btn btn-primary btn-lg" value="Submit">
</form>
</body>
</html>