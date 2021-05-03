let count = 0;

function send_username() {
    var name = $("#input_username").val();
    var url = window.location.href;

    document.location.href = url.split("?")[0] + '?' + 'userName=' + name;

}

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
                aChatroom[aChatroom.length] = value;
            } else if (isAdd === 1) {
                if (aChatroomIndex.indexOf(this_timestamp + "" + this_name) === -1) {
                    aChatroomIndex[aChatroomIndex.length] = this_timestamp + "" + this_name;
                    aChatroom[aChatroom.length] = value;
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
            if (is_radio)
                speechSynthesis.speak(speech);
        }
        aChatroomSend = [];
    }

    setTimeout(function () {
        sChatroom = getNewDate("chatroom.txt");
        setChatroom(sChatroom);
    }, 7000 - isAdd * 3000);
}

function setOnlineUser(oHistory) {
    oHistory = JSON.parse(oHistory);
    $("#online_user").html("");
    for (const [key, value] of Object.entries(oHistory)) {
        $("#online_user").append('<li class="list-group-item">' + value['name'] + '</li>')
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
            // setTimeout(playVideo, 2000);
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
    if (is_radio)
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

async function createText(text) {
    let div_text = document.createElement('div.bennyTest');
    div_text.id = "text" + count;
    count++;
    div_text.style.position = 'fixed';
    div_text.style.whiteSpace = 'nowrap'
    div_text.style.left = (document.documentElement.clientWidth) + 'px';
    var random = Math.round(Math.random() * document.documentElement.clientHeight);
    div_text.style.top = random + 'px';
    div_text.appendChild(document.createTextNode(text));
    document.body.appendChild(div_text);

    await gsap.to("#" + div_text.id, {
        duration: 5,
        x: -1 * (document.documentElement.clientWidth + div_text.clientWidth)
    });

    div_text.parentNode.removeChild(div_text);
}

