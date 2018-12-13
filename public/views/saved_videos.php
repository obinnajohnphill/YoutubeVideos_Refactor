
<?php

include dirname(__FILE__).'/../../vendor/autoload.php';

use Obinna\Services\YoutubeVideosContainer;

session_unset();
session_start();

 //echo json_encode($_SESSION,JSON_FORCE_OBJECT);

if (!empty ($_SESSION['msg'])){
    $message = $_SESSION['msg'];
    echo '<div style="color:#4a8b15">' .$message.'</div>';
    session_unset();
}
if (!empty ($_SESSION['delete-msg'])){
    $message = $_SESSION['delete-msg'];
    echo '<div style="color:red">' .$message.'</div>';
    session_unset();
}
?>
<!doctype html>
<html>
<head>
    <title>YouTube Search</title>
    <script src="https://cdn.rawgit.com/janl/mustache.js/master/mustache.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/views.css">
    <script src="../js/views.js"></script>
    <script src="../js/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
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

    <div id="payload" class="videoDiv">
        <div v-for="item in items">
            <iframe id="iframe" style="width:100%;height:100%"
                    :src="'https://www.youtube.com/embed/'+item.videoId+'?autoplay=0&origin=http://example.com'"
                    frameborder="0"></iframe>
            <b> {{item.title}}</b><br>
            <fieldset id="group_1">
                <input type="checkbox" id="checkbox" name="checkbox[]">
                <label for="checkbox"></label><br>
                <input  type="hidden" name="videoId[]"  v-model="item.videoId">
                <input type="hidden" name="title[]"  v-model="item.title">
            </fieldset><br>
        </div>
    </div>


<input type="submit" class="btn btn-danger btn-lg" value="Delete">

</form>

<script>
    new Vue({
        el: '#payload',
        data: {
            items:
                <?php echo json_encode($_SESSION['data'],JSON_FORCE_OBJECT); ?>
        }
    })

</script>
</body>
</html>