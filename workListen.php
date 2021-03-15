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
    <link href="css/blog-home.css?v1.0.0" rel="stylesheet">

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container header_container">
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
            <button id="btn_user_name" type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#exampleModal"
                    style="display: none;"
            >
                修改暱稱
            </button>
            <!-- 待播清單 -->
            <div class="card mb-4">
                <h5 class="card-header">待播清單</h5>
                <div class="card-body playlist">
                    <p class="card-text">若清單為空會從近100歷史紀錄隨機則一</p>
                    <ul class="list-group list-group-flush" id="broadcast">
                        <!--                        <li class="list-group-item">Cras justo odio</li>-->
                    </ul>
                </div>
            </div>

            <!-- 歷史紀錄 -->
            <div class="card mb-4">
                <h5 class="card-header">歷史紀錄</h5>
                <div class="card-body playlist">
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
                    <button class="btn btn-primary" type="button" data-toggle="collapse"
                            data-target="#collapse_youtube_keyword" aria-expanded="false"
                            aria-controls="collapse_youtube_keyword" style="float: right;">展開
                    </button>
                </h5>
                <div class="collapse" id="collapse_youtube_keyword">
                    <div class="card-body">
                        <div class="input-group">
                            <input type="text" class="form-control" id="youtube_keyword" placeholder="請輸入關鍵字"
                                   value="孫雪寧"/>
                            <span class="input-group-append">
                          <button class="btn btn-danger" type="button" onclick="search()">搜尋</button>
                        </span>
                            <hr/>

                        </div>

                    </div>
                    <div id="youtube_search_div" class="youtube_search_div"></div>
                </div>
            </div>
            <div class="card mb-4">
                <h5 class="card-header">
                    搜尋頻道
                    <button class="btn btn-primary" type="button" data-toggle="collapse"
                            data-target="#collapse_youtube_playlist_keyword" aria-expanded="false"
                            aria-controls="collapse_youtube_playlist_keyword" style="float: right;">展開
                    </button>
                </h5>
                <div class="collapse" id="collapse_youtube_playlist_keyword">
                    <div class="card-body">
                        <div class="input-group">
                            <input type="text" class="form-control" id="youtube_playlist_keyword" placeholder="請輸入頻道ID"
                                   value="PLzw4iZ9KuGpjypW9796-46757KF_5R9WN"/>
                            <span class="input-group-append">
                          <button class="btn btn-danger" type="button" onclick="searchPlaylist()">搜尋</button>
                        </span>
                            <hr/>

                        </div>
                    </div>
                    <div id="youtube_search_playlist_div" class="youtube_search_div"></div>
                </div>
            </div>
            <div class="card mb-4">
                <h5 class="card-header">
                    即時廣播聊天室
                    <button class="btn btn-primary" type="button" data-toggle="collapse"
                            data-target="#collapse_chatroom" aria-expanded="false"
                            aria-controls="collapse_chatroom" style="float: right;">展開
                    </button>
                </h5>
                <div class="collapse" id="collapse_chatroom">
                    <div class="card-body">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">用戶暱稱</span>
                            </div>
                            <input type="text" class="form-control" id="chatroom_name" placeholder="您的暱稱"/>
                        </div>
                        <div class="imessage" id="chatroom_imessage"></div>
                        <div class="input-group">
                            <input type="text" class="form-control" id="chatroom_msg" placeholder="請輸入您的訊息"/>
                            <span class="input-group-append">
                                <button class="btn btn-info" type="button" onclick="sendMsg();">送出</button>

                            </span>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true"
                     data-backdrop="static" data-keyboard="false"
                >
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">請輸入您的暱稱</h5>
                            </div>
                            <div class="modal-body">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">用戶暱稱</span>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                                id="input_username_close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control" id="input_username" placeholder="您的暱稱"/>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" onclick="send_username()">送出</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4" id="div_online_user">
                <h5 class="card-header">
                    當前在線
                    <button class="btn btn-primary" type="button" data-toggle="collapse"
                            data-target="#collapse_online" aria-expanded="false"
                            aria-controls="collapse_online" style="float: right;">展開
                    </button>
                </h5>
                <div class="collapse" id="collapse_online">
                    <div class="card-body" >
                        <ul class="list-group" id="online_user">
                        </ul>
                    </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
<script>
    <?php
    echo 'var userName="' . (empty($_GET['userName']) ? '' : $_GET['userName']) . '";';
    ?>
    function send_username() {
        var name = $("#input_username").val();
        var url = window.location.href;

        document.location.href = url.split("?")[0] + '?' + 'userName=' + name;

    }
    if (userName !== '') {
        var videoId = '';
        var tableId = '';
        var timestamp = '';
        var player;
        var videoType = '';
        var aChatroom = [];
        var aChatroomIndex = [];
        var aChatroomSend = [];
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api"; // Take the API address.
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag); // Include the API inside the page.
        //AIzaSyA5wYIKmGNmhE0qNaPYnZmeApz7v_OhhsU

        function setBroadcast(sBroadcast) {
            $("#broadcast").html("");
            var oBroadcast = JSON.parse(sBroadcast);
            for (const [key, value] of Object.entries(oBroadcast)) {
                if (videoId === '') {
                    tableId = value.id;
                    videoId = value.youtube_id;
                    timestamp = value.timestamp;
                    $("#player_title").html(value.title);
                }
                var title2 = value.title;
                if (title2.length > 43) {
                    title2 = title2.slice(0, 40) + '...';
                }
                if (key === '0') {
                    $("#broadcast").append('<li class="list-group-item"> ' + title2 + '</li>');
                } else {
                    $("#broadcast").append('<li class="list-group-item"><button class="btn btn-dark" type="button" onclick="del(\'' + value.id + '\')">刪除</button> - ' + title2 + '</li>');
                }

            }
        }

        function setHistory(sHistory) {
            $("#history").html("");
            var oHistory = JSON.parse(sHistory);
            var index = Math.floor(Math.random() * Object.keys(oHistory).length);
            for (const [key, value] of Object.entries(oHistory)) {
                var title1 = value.title;
                if (title1.length > 43) {
                    title1 = title1.slice(0, 40) + '...';
                }
                $("#history").append('<li class="list-group-item">' +
                    '<button class="btn btn-info" type="button" onclick="add(\'' + value.id + '\',\'' + value.title + '\')">點播</button>\n' +
                    '<button class="btn btn-warning" type="button" onclick="interstitial(\'' + value.id + '\',\'' + value.title + '\')">插播</button> - ' +
                    title1 + '</li>');
            }
        }

        function setChatroom(sHistory) {
            var aArray = JSON.parse(sHistory);
            var oHistory = JSON.parse(aArray[0]);
            setOnlineUser(aArray[1]);
            var length = Object.keys(oHistory).length;
            var isAdd = 0;
            if (aChatroom.length === 0) {
                isAdd = 2;
            } else if (aChatroom.length !== length) {
                isAdd = 1;
            } else if (oHistory[length - 1]['timestamp'] !== aChatroom[aChatroom.length - 1]['timestamp']) {
                isAdd = 1;
            }
            if (isAdd === 1 || isAdd === 2) {
                $("#chatroom_imessage").html("");
                var name = $("#chatroom_name").val();
                // <p>2021/03/15 11:24:01</p>
                // <p class="from-them">YYY : 123456</p>
                // <p>2021/03/15 11:24:00</p>
                // <p class="from-me">Benny : 123456</p>
                for (const [key, value] of Object.entries(oHistory)) {
                    var this_timestamp = parseInt(value.timestamp + "000");
                    var this_name = value.name;
                    var this_msg = value.msg;
                    var date = new Date(this_timestamp);
                    var _class = "from-them";
                    if (this_name === name) {
                        _class = "from-me";
                    }
                    Y = date.getFullYear() + '-';
                    M = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '-';
                    D = date.getDate() + ' ';
                    h = date.getHours() + ':';
                    m = date.getMinutes() + ':';
                    s = date.getSeconds();
                    $("#chatroom_imessage")
                        .prepend('<p class="' + _class + '">' + this_name + ' : ' + this_msg + '</p>')
                        .prepend('<p>' + Y + M + D + h + m + s + '</p>');
                    if (isAdd === 2) {
                        aChatroomIndex[aChatroomIndex.length] = this_timestamp + "" + this_name;
                        aChatroom[value.timestamp] = oHistory;
                    } else if (isAdd === 1) {
                        if (aChatroomIndex.indexOf(this_timestamp + "" + this_name) === -1) {
                            aChatroomIndex[aChatroomIndex.length] = this_timestamp + "" + this_name;
                            aChatroom[value.timestamp] = oHistory;
                            aChatroomSend[aChatroomSend.length] = this_name + "說" + this_msg;
                            if (aChatroomIndex.length > 20) {
                                aChatroomIndex.shift();
                                aChatroom.shift();
                            }
                        }
                    }
                }
                for (let i = 0; i < aChatroomSend.length; i++) {
                    var speech = new SpeechSynthesisUtterance();
                    speech.text = aChatroomSend[i];// 获取并设置说话时的文本
                    createText(speech.text);
                    speechSynthesis.speak(speech);
                }
                aChatroomSend = [];
            }

            setTimeout(function () {
                sChatroom = getNewDate("chatroom.txt");
                setChatroom(sChatroom);
            }, 2000);
        }

        function setOnlineUser(oHistory){
            oHistory = JSON.parse(oHistory);
            $("#online_user").html("");
            for (const [key, value] of Object.entries(oHistory)) {
                $("#online_user").append('<li class="list-group-item">'+value['name']+'</li>')
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
                startSeconds = timestamp_now - parseInt(timestamp);
            }
            player.loadVideoById({videoId: videoId, startSeconds: startSeconds,})
        }

        function onPlayerStateChange(event) {
            console.log('onPlayerStateChange = ' + event.data);
            videoType = event.data;
            if (event.data === YT.PlayerState.ENDED) {
                if (userName === "admin") {
                    end();
                } else {
                    setTimeout(end, 3000);
                }
            } else if (event.data === YT.PlayerState.PAUSED) {
            } else if (event.data === YT.PlayerState.PLAYING) {
            } else if (event.data === YT.PlayerState.BUFFERING) {
            } else if (event.data === YT.PlayerState.CUED) {
            } else {
            }
        }

        function checkVideoType() {
            videoType = player.getPlayerState();
            if (videoType === -1) {
                end();
            } else {
                setTimeout(loadVideoById, 10000);
            }
        }

        function end() {
            videoType = player.getPlayerState();
            $.ajax({
                type: 'GET',
                async: false,
                url: './workListenAction.php?type=end&id=' + tableId + '&admin=' + userName + '&videoType=' + videoType,
                success: function (rp) {
                    videoId = "";
                    tableId = "";
                    timestamp = "";
                    var oList = JSON.parse(rp);
                    setBroadcast(oList[0]);
                    setHistory(oList[1]);
                    if (videoType === -1) {
                        setTimeout(loadVideoByIdAfterError, 500);
                    }
                    setTimeout(playVideo, 2000);
                    setTimeout(loadVideoById, 4000);
                    setTimeout(checkVideoType, 8000);
                }
            });
        }

        function loadVideoById() {
            console.log("loadVideoById videoId = " + videoId);
            if (timestamp === '') {
                startSeconds = 0
            } else {
                var timestamp_now = Date.parse(new Date()) / 1000;
                startSeconds = timestamp_now - timestamp;
            }
            console.log(startSeconds);
            videoType = player.getPlayerState();
            if (videoType !== -1)
                player.loadVideoById({videoId: videoId, startSeconds: startSeconds,})
        }

        function loadVideoByIdAfterError() {
            if (timestamp === '') {
                startSeconds = 0
            } else {
                var timestamp_now = Date.parse(new Date()) / 1000;
                startSeconds = timestamp_now - timestamp;
            }
            player.loadVideoById({videoId: videoId, startSeconds: startSeconds,})
        }

        function stopVideo() {
            player.stopVideo();
        }

        function add(id, title) {
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
                    setBroadcast(rp);
                }
            });
        }

        function interstitial(id, title) {
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
            var url = 'https://www.googleapis.com/youtube/v3/videos?id=' + videoId + '&key=' + 'AIzaSyA5wYIKmGNmhE0qNaPYnZmeApz7v_OhhsU&part=snippet';
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
                url: './workListenAction.php?type=read&filename=' + fileName + '&userName=' + userName,
                success: function (rp) {
                    title = rp
                }
            });
            return title;
        }

        function search() {
            var youtube_keyword = $("#youtube_keyword").val();
            $("#youtube_keyword").val("");
            $.ajax({
                type: 'GET',
                async: false,
                url: 'https://www.googleapis.com/youtube/v3/search?part=snippet&q=' + youtube_keyword + '&key=AIzaSyA5wYIKmGNmhE0qNaPYnZmeApz7v_OhhsU&type=video&maxResults=10',
                success: function (rp) {
                    $("#youtube_search_div").html("");
                    for (var i = 0; i < rp.items.length; i++) {
                        var thisOne = rp.items[i];
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
            var youtube_keyword = $("#youtube_playlist_keyword").val();
            $("#youtube_playlist_keyword").val("");
            $.ajax({
                type: 'GET',
                async: false,
                url: 'https://www.googleapis.com/youtube/v3/playlistItems?part=contentDetails%2Csnippet&playlistId=' + youtube_keyword + '&key=AIzaSyA5wYIKmGNmhE0qNaPYnZmeApz7v_OhhsU&type=video&maxResults=9999',
                success: function (rp) {
                    $("#youtube_search_playlist_div").html("");
                    for (var i = 0; i < rp.items.length; i++) {
                        var thisOne = rp.items[i];
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

        function playVideo() {
            var title = $("#player_title").html();
            title = "現在播放的是" + title.replace(/\s*/g, "");
            console.log(title);
            // //         https://translate.google.com/translate_tts?ie=UTF-8&tl=zh_tw&client=tw-ob&ttsspeed=1&q=1234
            // var url = 'https://translate.google.com/translate_tts?ie=UTF-8&tl=zh_tw&client=tw-ob&ttsspeed=1&q=' + title;
            // document.getElementById("videoPlayer").src = url;
            // // document.getElementById("videoPlayer").load();
            // document.getElementById("videoPlayer").play();
            var speech = new SpeechSynthesisUtterance();
            speech.text = title;// 获取并设置说话时的文本
            speechSynthesis.speak(speech);
        }

        function sendMsg() {
            var name = $("#chatroom_name").val();
            var msg = $("#chatroom_msg").val();
            if (name === "" || msg === "") {
                alert("請輸入您的暱稱或信息")
            }
            $.ajax({
                type: 'GET',
                async: false,
                url: './workListenAction.php?type=sendMsg&name=' + name + '&msg=' + msg,
                success: function (rp) {
                    $("#chatroom_name").attr('disabled', true);
                    $("#chatroom_msg").val("");
                    setChatroom(rp);
                }
            });
        }



        $("#chatroom_name").val(userName);
        $("#chatroom_name").attr('disabled', true);

        var sBroadcast = getNewDate("broadcast.txt");
        var sHistory = getNewDate("history.txt");
        var sChatroom = getNewDate("chatroom.txt");

        setBroadcast(sBroadcast);
        setHistory(sHistory);
        setChatroom(sChatroom);
        videoId = (videoId === '') ? 'rshfNb2ped8' : videoId;
        console.log('videoId = ' + videoId);

        if (userName !== 'admin' && userName !== 'Benny') {
            $("#div_online_user").hide();
        }

        let count = 0;
        async function createText(text) {
            let div_text = document.createElement('div.bennyTest');
            div_text.id="text"+count;
            count++;
            div_text.style.position = 'fixed';
            div_text.style.whiteSpace = 'nowrap'
            div_text.style.left = (document.documentElement.clientWidth) + 'px';
            var random = Math.round( Math.random()*document.documentElement.clientHeight );
            div_text.style.top = random + 'px';
            div_text.appendChild(document.createTextNode(text));
            document.body.appendChild(div_text);

            await gsap.to("#"+div_text.id, {duration: 5, x: -1*(document.documentElement.clientWidth+div_text.clientWidth)});

            div_text.parentNode.removeChild(div_text);
        }

    }
    else{
        $("#btn_user_name").trigger('click');
    }
</script>
</body>
</html>
