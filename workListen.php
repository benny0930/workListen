<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>辦公室點歌系統</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/blog-home.css" rel="stylesheet">

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">辦公室點歌系統</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <!--        <ul class="navbar-nav ml-auto">-->
            <!--          <li class="nav-item active">-->
            <!--            <a class="nav-link" href="#">首頁-->
            <!--              <span class="sr-only">(current)</span>-->
            <!--            </a>-->
            <!--          </li>-->
            <!--          <li class="nav-item">-->
            <!--            <a class="nav-link" href="#">About</a>-->
            <!--          </li>-->
            <!--          <li class="nav-item">-->
            <!--            <a class="nav-link" href="#">Services</a>-->
            <!--          </li>-->
            <!--          <li class="nav-item">-->
            <!--            <a class="nav-link" href="#">Contact</a>-->
            <!--          </li>-->
            <!--        </ul>-->
        </div>
    </div>
</nav>

<!-- Page Content -->
<div class="container">

    <div class="row">
        <div class="col-md-12">

            <h1 class="my-4">當前播放
                <small id="player_title"></small>
            </h1>

            <!-- Blog Post -->
            <div class="card mb-12">
                <div class="card-body">
                    <div id="YouTubeVideoPlayerAPI" style="width: 100%"></div>
                </div>
            </div>
        </div>
        <hr>
    </div>
    <hr/>
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <!-- 待播清單 -->
            <div class="card mb-4">
                <h5 class="card-header">待播清單</h5>
                <div class="card-body">
                    <p class="card-text">若清單為空會從近100歷史紀錄隨機則一</p>
                    <ul class="list-group list-group-flush" id="broadcast">
                        <!--                        <li class="list-group-item">Cras justo odio</li>-->
                    </ul>
                </div>
            </div>

            <!-- 歷史紀錄 -->
            <div class="card mb-4">
                <h5 class="card-header">歷史紀錄</h5>
                <div class="card-body">
                    <ul class="list-group list-group-flush" id="history">
                        <!--                        <li class="list-group-item">Cras justo odio</li>-->
                    </ul>
                </div>
            </div>
        </div>
        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

            <!-- Search Widget -->
            <div class="card mb-4">
                <h5 class="card-header">點播歌曲</h5>
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" class="form-control" id="youtube_url" placeholder="Youtube 網址"/>
                        <span class="input-group-append">
                          <button class="btn btn-info" type="button" onclick="add('','')">點播</button>
                          <button class="btn btn-warning" type="button" onclick="interstitial('','')">插播</button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <h5 class="card-header">
                    搜尋歌曲
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse_youtube_keyword" aria-expanded="false" aria-controls="collapse_youtube_keyword" style="float: right;">展開</button>
                </h5>
                <div class="collapse" id="collapse_youtube_keyword">
                    <div class="card-body">
                        <div class="input-group">
                            <input type="text" class="form-control" id="youtube_keyword" placeholder="請輸入關鍵字" value="孫雪寧"/>
                            <span class="input-group-append">
                          <button class="btn btn-danger" type="button" onclick="search()">搜尋</button>
                        </span>
                            <hr/>

                        </div>

                    </div>
                    <div id="youtube_search_div" style="height: 500px;overflow: auto;"></div>
                </div>
            </div>
            <div class="card mb-4">
                <h5 class="card-header">
                    搜尋頻道
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse_youtube_playlist_keyword" aria-expanded="false" aria-controls="collapse_youtube_playlist_keyword" style="float: right;">展開</button>
                </h5>
                <div class="collapse" id="collapse_youtube_playlist_keyword">
                    <div class="card-body">
                        <div class="input-group">
                            <input type="text" class="form-control" id="youtube_playlist_keyword" placeholder="請輸入關鍵字" value="PLzw4iZ9KuGpiOqlFuI8rRrGrfb2z6AQHh"/>
                            <span class="input-group-append">
                          <button class="btn btn-danger" type="button" onclick="searchPlaylist()">搜尋</button>
                        </span>
                            <hr/>

                        </div>
                    </div>
                    <div id="youtube_search_playlist_div" style="height: 500px;overflow: auto;"></div>
                </div>

            </div>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->
<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; BLiu 2021 v1.0.0</p>
    </div>
    <!-- /.container -->
</footer>
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
    <?php
    echo 'var admin="' . (empty($_GET['admin']) ? 'user' : $_GET['admin']) . '";';
    ?>
    var videoId = '';
    var timestamp = '';
    var player;
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api"; // Take the API address.
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag); // Include the API inside the page.
    //AIzaSyA5wYIKmGNmhE0qNaPYnZmeApz7v_OhhsU

    function setBroadcast(sBroadcast) {
        console.log('設定待播清單');
        $("#broadcast").html("");
        var oBroadcast = JSON.parse(sBroadcast);
        for (const [key, value] of Object.entries(oBroadcast)) {
            if (videoId === '') {
                videoId = value.id;
                timestamp = value.timestamp;
                $("#player_title").html(value.title);
            }
            console.log(value);
            var title2 = value.title;
            if (title2.length > 43) {
                title2 = title2.slice(0, 40) + '...';
            }
            if (key === '0') {
                $("#broadcast").append('<li class="list-group-item"> ' + title2 + '</li>');
            } else {
                console.log('setset');
                console.log(value);
                $("#broadcast").append('<li class="list-group-item"><button class="btn btn-dark" type="button" onclick="del(\'' + value.id + '\')">刪除</button> - ' + title2 + '</li>');
            }

        }
    }

    function setHistory(sHistory) {
        console.log('設定歷史紀錄');
        $("#history").html("");
        var oHistory = JSON.parse(sHistory);
        var index = Math.floor(Math.random() * Object.keys(oHistory).length);
        for (const [key, value] of Object.entries(oHistory)) {
            console.log(typeof value);
            if (videoId === '' && parseInt(key) === index) {
                videoId = value.id;
                timestamp = value.timestamp;
                $("#player_title").html(value.title);
            }
            var title1 = value.title;
            if (title1.length > 43) {
                title1 = title1.slice(0, 40) + '...';
            }
            $("#history").append('<li class="list-group-item">' +
                '<button class="btn btn-info" type="button" onclick="add(\'' + value.id + '\',\'' + value.title + '\')">點播</button>\n' +
                '<button class="btn btn-warning" type="button" onclick="interstitial(\'' + value.id + '\',\'' + value.title + '\')">插播</button>' +
                title1 + '</li>');
        }
    }

    function onYouTubeIframeAPIReady() {
        try {
            console.log('onYouTubeIframeAPIReady');
            player = new YT.Player('YouTubeVideoPlayerAPI', {
                videoId: videoId,   // YouTube 影片ID
                height: '640',           // 播放器高度 (px)
                playerVars: {
                    autoplay: 1,            // 自動播放影片
                    controls: 1,            // 顯示播放器
                    showinfo: 0,            // 隱藏影片標題
                    modestbranding: 0,      // 隱藏YouTube Logo
                    loop: 0,                // 重覆播放
                    playlist: videoId, // 當使用影片要重覆播放時，需再輸入YouTube 影片ID
                    fs: 0,                  // 隱藏全螢幕按鈕
                    cc_load_policty: 0,     // 隱藏字幕
                    iv_load_policy: 3,      // 隱藏影片註解
                    // autohide: 0             // 影片播放時，隱藏影片控制列
                    start: 60,
                    end: 999999,
                },
                events: {
                    onReady: onPlayerReady,
                    onStateChange: onPlayerStateChange,

                }
            });
        } catch (e) {
            console.log("onYouTubeIframeAPIReady 錯誤");
            console.log(e);
        }

    }

    function onPlayerReady(e) {
        console.log('onPlayerReady');
        $("#player_title").html(e.target.getVideoData().title);
        e.target.mute();      //播放時靜音
        e.target.playVideo();
        if (timestamp === '') {
            startSeconds = 0
        } else {
            var timestamp_now = Date.parse(new Date()) / 1000;
            startSeconds = timestamp_now - timestamp;
        }

        player.loadVideoById({videoId: videoId, startSeconds: startSeconds,})
    }

    function onPlayerStateChange(event) {
        console.log('onPlayerStateChange = ' + event.data);
        if (event.data === YT.PlayerState.ENDED) {
            console.log("結束");
            console.log(admin);
            if (admin === "admin") {
                end();
            } else {
                setTimeout(end, 3000);
            }
        } else if (event.data === YT.PlayerState.PAUSED) {
            console.log("暫停");
        } else if (event.data === YT.PlayerState.PLAYING) {
            console.log("播放");
        } else if (event.data === YT.PlayerState.BUFFERING) {
            console.log("讀取中");
        } else if (event.data === YT.PlayerState.CUED) {
            console.log("提示");
        } else {
            console.log("未知狀態");
        }
    }

    function end() {
        console.log('End workListenAction');
        $.ajax({
            type: 'GET',
            async: false,
            url: './workListenAction.php?type=end&id=' + videoId + '&admin=' + admin,
            success: function (rp) {
                console.log(rp);
                videoId = "";
                timestamp = "";
                var oList = JSON.parse(rp);
                setBroadcast(oList[0]);
                setHistory(oList[1]);
                setTimeout(loadVideoById, 2000);
                setTimeout(loadVideoById, 5000);
            }
        });
    }

    function loadVideoById() {
        if (timestamp === '') {
            startSeconds = 0
        } else {
            var timestamp_now = Date.parse(new Date()) / 1000;
            startSeconds = timestamp_now - timestamp;
        }
        player.loadVideoById({videoId: videoId, startSeconds: startSeconds,})
    }

    function stopVideo() {
        console.log('stopVideo');
        player.stopVideo();
    }

    function add(id, title) {
        console.log('點播 Add - ' + id + " - " + title);
        if (id === "") {
            var url = $("#youtube_url").val();
            $("#youtube_url").val("");
            var aUrl = url.split('?');
            var aUrlOne = aUrl[1].split('&');
            var id = '';
            for (var i = 0; i < aUrlOne.length; i++) {
                var aUrlOneOne = aUrlOne[i].split('=');
                if (aUrlOneOne[0] === "v") {
                    id = aUrlOneOne[1];
                    break;
                }
            }
            title = getVideoInfo(id);
        }

        $.ajax({
            type: 'GET',
            async: false,
            url: './workListenAction.php?type=add&filename=broadcast.txt&id=' + id + '&title=' + title,
            success: function (rp) {
                console.log(rp)
                setBroadcast(rp);
            }
        });


    }

    function del(id) {
        $.ajax({
            type: 'GET',
            async: false,
            url: './workListenAction.php?type=del&filename=broadcast.txt&id=' + id,
            success: function (rp) {
                console.log(rp)
                setBroadcast(rp);
            }
        });
    }

    function interstitial(id, title) {
        console.log('插播 interstitial - ' + id + " - " + title);
        if (id === "") {
            var url = $("#youtube_url").val();
            $("#youtube_url").val("");
            var aUrl = url.split('?');
            var aUrlOne = aUrl[1].split('&');
            var id = '';
            for (var i = 0; i < aUrlOne.length; i++) {
                var aUrlOneOne = aUrlOne[i].split('=');
                if (aUrlOneOne[0] === "v") {
                    id = aUrlOneOne[1];
                    break;
                }
            }
            title = getVideoInfo(id);
        }

        $.ajax({
            type: 'GET',
            async: false,
            url: './workListenAction.php?type=interstitial&filename=broadcast.txt&id=' + id + '&title=' + title,
            success: function (rp) {
                // console.log(rp)
                setBroadcast(rp);
            }
        });
    }

    function getVideoInfo(videoId) {
        if (typeof videoId == 'undefined' || videoId === '') {
            show_content('請輸入影片編號');
            return false;
        }
        var title = "";
        var url = 'https://www.googleapis.com/youtube/v3/videos?id=' + videoId + '&key=' + 'AIzaSyA5wYIKmGNmhE0qNaPYnZmeApz7v_OhhsU' + '&part=snippet';
        $.ajax({
            type: 'GET',
            async: false,
            url: url,
            success: function (rp) {
                title = rp.items[0].snippet.title;
            }
        });
        return title;
    }

    function getNewDate(fileName) {
        var title = "{}";
        $.ajax({
            type: 'GET',
            async: false,
            url: './workListenAction.php?type=read&filename=' + fileName,
            success: function (rp) {
                title = rp
            }
        });
        return title;
    }

    function search() {
        console.log('搜尋');
        var youtube_keyword = $("#youtube_keyword").val();
        $("#youtube_keyword").val("");
        $.ajax({
            type: 'GET',
            async: false,
            url: 'https://www.googleapis.com/youtube/v3/search?part=snippet&q=' + youtube_keyword + '&key=AIzaSyA5wYIKmGNmhE0qNaPYnZmeApz7v_OhhsU&type=video&maxResults=10',
            success: function (rp) {
                $("#youtube_search_div").html("");
                console.log(rp);

                for (var i = 0; i < rp.items.length; i++) {
                    var thisOne = rp.items[i];
                    console.log();
                    var img = $("<img class=\"card-img-top\" src=\"" + thisOne.snippet.thumbnails.high.url + "\" alt=\"Card image cap\">");
                    var body = $("<div class=\"card-body\"><div>").append("<p class=\"card-text\">" + thisOne.snippet.title + "</p>");
                    body.append("<button class=\"btn btn-info\" type=\"button\" onclick=\"add('" + thisOne.id.videoId + "','" + thisOne.snippet.title + "')\">點播</button>");
                    body.append("<button class=\"btn btn-warning\" type=\"button\" onclick=\"interstitial('" + thisOne.id.videoId + "','" + thisOne.snippet.title + "')\">插播</button>");
                    var div = $("<div class=\"card-body\"><div class=\"card\" style=\"width: 18rem;\"><div><div>").append(img).append(body)
                    $("#youtube_search_div").append(div);
                }
            }
        });
    }

    function searchPlaylist() {
        console.log('搜尋');
        var youtube_keyword = $("#youtube_playlist_keyword").val();
        $("#youtube_playlist_keyword").val("");
        $.ajax({
            type: 'GET',
            async: false,
            url: 'https://www.googleapis.com/youtube/v3/playlistItems?part=contentDetails%2Csnippet&playlistId=' + youtube_keyword + '&key=AIzaSyA5wYIKmGNmhE0qNaPYnZmeApz7v_OhhsU&type=video&maxResults=9999',
            success: function (rp) {
                $("#youtube_search_playlist_div").html("");
                console.log(rp);
                
                for (var i = 0; i < rp.items.length; i++) {
                    var thisOne = rp.items[i];
                    console.log();
                    var img = $("<img class=\"card-img-top\" src=\"" + thisOne.snippet.thumbnails.high.url + "\" alt=\"Card image cap\">");
                    var body = $("<div class=\"card-body\"><div>").append("<p class=\"card-text\">" + thisOne.snippet.title + "</p>");
                    body.append("<button class=\"btn btn-info\" type=\"button\" onclick=\"add('" + thisOne.contentDetails.videoId + "','" + thisOne.snippet.title + "')\">點播</button>");
                    body.append("<button class=\"btn btn-warning\" type=\"button\" onclick=\"interstitial('" + thisOne.contentDetails.videoId + "','" + thisOne.snippet.title + "')\">插播</button>");
                    var div = $("<div class=\"card-body\"><div class=\"card\" style=\"width: 18rem;\"><div><div>").append(img).append(body)
                    $("#youtube_search_playlist_div").append(div);
                }
            }
        });
    }


    console.log('讀取播放清單');
    var sBroadcast = getNewDate("broadcast.txt");
    setBroadcast(sBroadcast);
    console.log("讀取歷史清單");
    var sHistory = getNewDate("history.txt");
    setHistory(sHistory);
    videoId = (videoId === '') ? 'rshfNb2ped8' : videoId;
    console.log('videoId = ' + videoId);


</script>
</body>
</html>
