<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Page Not Found</title>
    <script src="http://dynamicsjs.com/lib/dynamics.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/views.css">
    <script src="../js/views.js"></script>
    <!-- template for the component -->
    <script type="text/x-template" id="header-view-template">
        <div class="draggable-header-view"
             @mousedown="startDrag" @touchstart="startDrag"
             @mousemove="onDrag" @touchmove="onDrag"
             @mouseup="stopDrag" @touchend="stopDrag" @mouseleave="stopDrag">
            <svg class="bg" width="320" height="560">
                <path :d="headerPath"  fill="#337ab7"></path>
            </svg>
            <div class="header">
                <slot name="header"></slot>
            </div>
            <div class="content" :style="contentPosition">
                <slot name="content"></slot>
            </div>
        </div>
    </script>

    <style>
        h1 {
            font-weight: 300;
            font-size: 1.8em;
            margin-top: 0;
        }
        a {
            color: #fff;
        }
        .draggable-header-view {
            background-color: #fff;
            box-shadow: 0 4px 16px rgba(0,0,0,.15);
            width: 50%;
            height: 70%;
            overflow: hidden;
            margin: 30px auto;
            position: relative;
            font-family: 'Roboto', Helvetica, Arial, sans-serif;
            color: #fff;
            font-size: 14px;
            font-weight: 300;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        .draggable-header-view .bg {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 0;
        }
        .draggable-header-view .header, .draggable-header-view .content {
            position: relative;
            z-index: 1;
            padding: 30px;
            box-sizing: border-box;
            width:100%;
        }
        .draggable-header-view .header {
            height: 160px;

        }
        .draggable-header-view .content {
            color: #333;
            line-height: 1.5em;
        }

    </style>
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

<div id="app" @touchmove.prevent>
    <draggable-header-view>
        <template slot="header">
            <h1>Page Not Found</h1>
        </template>
        <template slot="content">
            <p>
                <?php
                echo "<div align='center'><h1>Error 404: This page seems to not exist!</h1></div>";
                ?>
            </p>
        </template>
    </draggable-header-view>
</div>

<script>
    Vue.component('draggable-header-view', {
        template: '#header-view-template',
        data: function () {
            return {
                dragging: false,
                // quadratic bezier control point
                c: { x: 160, y: 160 },
                // record drag start point
                start: { x: 0, y: 0 }
            }
        },
        computed: {
            headerPath: function () {
                return 'M0,0 L320,0 320,160' +
                    'Q' + this.c.x + ',' + this.c.y +
                    ' 0,900'
            },
            contentPosition: function () {
                var dy = this.c.y - 160
                var dampen = dy > 0 ? 2 : 4
                return {
                    transform: 'translate3d(0,' + dy / dampen + 'px,0)'
                }
            }
        },
        methods: {
            startDrag: function (e) {
                e = e.changedTouches ? e.changedTouches[0] : e
                this.dragging = true
                this.start.x = e.pageX
                this.start.y = e.pageY
            },
            onDrag: function (e) {
                e = e.changedTouches ? e.changedTouches[0] : e
                if (this.dragging) {
                    this.c.x = 160 + (e.pageX - this.start.x)
                    // dampen vertical drag by a factor
                    var dy = e.pageY - this.start.y
                    var dampen = dy > 0 ? 1.5 : 4
                    this.c.y = 160 + dy / dampen
                }
            },
            stopDrag: function () {
                if (this.dragging) {
                    this.dragging = false
                    dynamics.animate(this.c, {
                        x: 160,
                        y: 160
                    }, {
                        type: dynamics.spring,
                        duration: 700,
                        friction: 280
                    })
                }
            }
        }
    })

    new Vue({ el: '#app' })
</script>
</body>
</html>
