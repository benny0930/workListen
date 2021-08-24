<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>辦公室點歌系統</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/blog-home.css?v=1.2" rel="stylesheet">
</head>
<body>
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
        <div class="col-md-4">
            <div class="card mb-4">
                <h5 class="card-header">控制項目</h5>
                <div class="card-body">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="radioCheckBox" checked>
                        <label class="form-check-label" for="radioCheckBox">廣播</label>
                    </div>
                </div>
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
<!--                <h5 class="card-header">-->
<!--                    即時廣播聊天室<br/>輸入「切歌」可以切歌-->
<!--                    <button class="btn btn-primary" type="button" data-toggle="collapse"-->
<!--                            data-target="#collapse_chatroom" aria-expanded="false"-->
<!--                            aria-controls="collapse_chatroom" style="float: right;">展開-->
<!--                    </button>-->
<!--                </h5>-->
                <div class="collapse" id="collapse_chatroom">
                    <div class="card-body">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">用戶暱稱</span>
                            </div>
                            <input type="text" class="form-control" id="chatroom_name" placeholder="您的暱稱"/>
                        </div>
                        <div class="imessage unselectable" id="chatroom_imessage"></div>
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
            <div class="card mb-4" id="div_online_user">
                <h5 class="card-header">
                    當前在線
                    <button class="btn btn-primary" type="button" data-toggle="collapse"
                            data-target="#collapse_online" aria-expanded="false"
                            aria-controls="collapse_online" style="float: right;">展開
                    </button>
                </h5>
                <div class="collapse" id="collapse_online">
                    <div class="card-body">
                        <ul class="list-group" id="online_user">
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <h5 class="card-header">
                    低潮夥伴
                    <button class="btn btn-primary" type="button" data-toggle="collapse"
                            data-target="#collapse_yua_mikami" aria-expanded="false"
                            aria-controls="collapse_yua_mikami" style="float: right;">展開
                    </button>
                </h5>
                <div class="collapse" id="collapse_yua_mikami">
                    <div class="card-body" id="collapse_yua_mikami_body"></div>
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
        </div>
    </div>
</div>
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; BLiu 2021 v1.0.0</p>
    </div>
    <!-- /.container -->
</footer>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
<script src="js/base.js"></script>
<script>
    <?php
    echo 'var userName="' . (empty($_GET['userName']) ? '' : $_GET['userName']) . '";';
    ?>
    if (userName !== '') {
        var videoId = '';
        var tableId = '';
        var timestamp = '';
        var player;
        var videoType = '';
        var is_radio = true;
        var aChatroom = [];
        var aChatroomIndex = [];
        var aChatroomSend = [];
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api"; // Take the API address.
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag); // Include the API inside the page.
        //AIzaSyA5wYIKmGNmhE0qNaPYnZmeApz7v_OhhsU

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

        // var aImages = [
        //     'https://instagram.fkhh1-2.fna.fbcdn.net/v/t51.2885-15/sh0.08/e35/c0.180.1440.1440a/s640x640/156849548_877893289451156_7788529398325407524_n.jpg?tp=1&_nc_ht=instagram.fkhh1-2.fna.fbcdn.net&_nc_cat=108&_nc_ohc=jA2Qsp-Xj_0AX_ifQMu&oh=5c72fdb8dbb01bb5461b19b1d5482979&oe=607814AC',
        //     'https://instagram.fkhh1-2.fna.fbcdn.net/v/t51.2885-15/e35/p1080x1080/160096652_815345335727764_1773984817380025631_n.jpg?tp=1&_nc_ht=instagram.fkhh1-2.fna.fbcdn.net&_nc_cat=104&_nc_ohc=xG7jXemlSdUAX-HzDNY&oh=5c9fd22450b137c5a91e211a9cd5aacc&oe=6079A44B',
        //     'https://instagram.fkhh1-1.fna.fbcdn.net/v/t51.2885-15/e35/c0.180.1440.1440a/s320x320/134252581_2889384648052577_783067974255837671_n.jpg?tp=1&_nc_ht=instagram.fkhh1-1.fna.fbcdn.net&_nc_cat=105&_nc_ohc=QUUr3HnCDpoAX_9drY-&oh=0132e39e3fe2f6c7659faee616d88d57&oe=6078CC15',
        //     'https://instagram.fkhh1-2.fna.fbcdn.net/v/t51.2885-15/e35/c0.180.1440.1440a/s320x320/132444749_196634048790694_8294525593193877986_n.jpg?tp=1&_nc_ht=instagram.fkhh1-2.fna.fbcdn.net&_nc_cat=110&_nc_ohc=UOjjw6xfoYwAX-FX_mw&oh=7e87ff27b52ba2c0d9197547b246ca91&oe=607B8E0E',
        //     'https://instagram.fkhh1-1.fna.fbcdn.net/v/t51.2885-15/e35/c0.108.1263.1263a/s320x320/119419401_2050081105124401_180860835831194261_n.jpg?tp=1&_nc_ht=instagram.fkhh1-1.fna.fbcdn.net&_nc_cat=101&_nc_ohc=LTRBL2wBcg0AX_Kc8UB&oh=62e2565a861ca146fbff4c17be0240b5&oe=6079B7AA',
        //     '',
        //     '',
        //     '',
        // ];
        // for (var i = 0; i < aImages.length; i++) {
        //     if (aImages[i] !== '')
        //         $("#collapse_yua_mikami_body").append('<div class=\"col-12 box bg-cover\" style=\"background-image: url(' + aImages[i] + ')\"></div>');
        // }
        $("#radioCheckBox").change(function () {
            is_radio = ($("#radioCheckBox:checked").length > 0);
        })
    } else {
        $("#btn_user_name").trigger('click');
    }
</script>
</body>
</html>
